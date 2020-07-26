package fr.martdel.codemanagermobile.controlers;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import fr.martdel.codemanagermobile.R;
import fr.martdel.codemanagermobile.models.Internet;
import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

public class SigninActivity extends AppCompatActivity {

    private AppCompatActivity activity;
    public static final String PREF_USER = "UsersPreferences";

    private EditText loginView, passwordView;
    private Button submitBtn;
    private ImageView homeBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signin);
        this.activity = this;

        this.loginView = findViewById(R.id.loginInput);
        this.passwordView = findViewById(R.id.passwordInput);
        this.submitBtn = findViewById(R.id.submitBtn);
        this.homeBtn = findViewById(R.id.homeBtn);

        submitBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // User tries to connect
                if(!Internet.isOnline(activity)){
                    Internet.errorConnection(activity);
                    return;
                }

                final String login = loginView.getText().toString();
                final String password = passwordView.getText().toString();

                // Check data
                if(login.length() == 0 || password.length() == 0) {
                    alert("Veuillez remplir tous les champs.");
                    return;
                }

                JSONObject body = new JSONObject();
                try {
                    body.put("table", "users");
                    body.put("where", null);
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                Internet.doAPIRequest("GET", body, null, new Callback() {
                    @Override
                    public void onFailure(@NotNull Call call, @NotNull IOException e) {
                        Internet.errorRequestPopUp(activity);
                    }

                    @Override
                    public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                        try {
                            JSONArray users = new JSONArray(response.body().string());
                            boolean user_exist = false;
                            for (int i = 0; i < users.length(); i++){
                                JSONObject user = users.getJSONObject(i);
                                final String current_pseudo = user.getString("pseudo");
                                final String current_email = user.getString("mail");
                                if(current_pseudo.equalsIgnoreCase(login) || current_email.equalsIgnoreCase(login)){
                                    // Correct login
                                    user_exist = true;
                                    Internet.doAPIRequest("GET", null, "?pseudo=" + Internet.urlEncode(current_pseudo) + "&password=" + Internet.urlEncode(Internet.encodeBase64(password)), new Callback() {
                                        @Override
                                        public void onFailure(@NotNull Call call, @NotNull IOException e) {
                                            Internet.errorRequestPopUp(activity);
                                        }

                                        @Override
                                        public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                                            try {
                                                boolean result = new JSONObject(response.body().string()).getBoolean("result");
                                                if(result){
                                                    // Correct password
                                                    runOnUiThread(new Runnable() {
                                                        @Override
                                                        public void run() {
                                                            SharedPreferences settings = getSharedPreferences(PREF_USER, 0);
                                                            SharedPreferences.Editor editor = settings.edit();
                                                            editor.putString("pseudo", current_pseudo);
                                                            editor.putString("mail", current_email);
                                                            editor.apply();

                                                            Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                                                            startActivity(githubActivity);
                                                            finish();
                                                        }
                                                    });
                                                } else {
                                                    alert("Le mot de passe n'est pas correct.");
                                                }
                                            } catch (JSONException e) {
                                                e.printStackTrace();
                                            }
                                        }
                                    });
                                }
                            }
                            if(!user_exist){
                                alert("Aucun compte utilisateur trouvé avec ce login.");
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                });
            }
        });

        homeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent mainActivity = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(mainActivity);
                finish();
            }
        });
    }

    @Override
    public void onBackPressed() {
        Intent mainActivity = new Intent(getApplicationContext(), MainActivity.class);
        startActivity(mainActivity);
        finish();
    }

    /**
     * Show toast message (long toast)
     * @param msg The printed message
     */
    public void alert(String msg){
        final String message = msg;
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                Toast.makeText(activity.getApplicationContext(), message, Toast.LENGTH_LONG).show();
            }
        });
    }
}