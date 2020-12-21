package fr.martdel.codemanagermobile.controlers;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import org.json.JSONException;

import java.util.regex.Pattern;

import fr.martdel.codemanagermobile.R;
import fr.martdel.codemanagermobile.models.CustomCallback;
import fr.martdel.codemanagermobile.models.Internet;
import fr.martdel.codemanagermobile.models.User;

public class SignupActivity extends AppCompatActivity {

    public static final String PREF_USER = "UsersPreferences";
    private AppCompatActivity activity;

    private EditText pseudoView, mailView;
    private EditText passwordView, confirmPasswordView;
    private Button submitBtn;
    private ImageView homeBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
        this.activity = this;

        this.pseudoView = findViewById(R.id.pseudoInput);
        this.mailView = findViewById(R.id.mailInput);
        this.passwordView = findViewById(R.id.passwordInput);
        this.confirmPasswordView = findViewById(R.id.confirmPasswordInput);
        this.submitBtn = findViewById(R.id.submitBtn);
        this.homeBtn = findViewById(R.id.homeBtn);

        submitBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // User sign up

                // Check internet connection
                if(!Internet.isOnline(activity)){
                    Internet.errorConnection(activity);
                    return;
                }

                String pseudo = pseudoView.getText().toString();
                String mail = mailView.getText().toString();
                final String password = passwordView.getText().toString();
                String confirm = confirmPasswordView.getText().toString();

                // Check data
                try {
                    if(pseudo.length() == 0 || mail.length() == 0 || password.length() == 0 || confirm.length() == 0) throw new Exception("Veuillez remplir tous les champs.");
                    if(!isEmail(mail)) throw new Exception("L'addresse e-mail n'est pas correct.");
                    if(!password.equalsIgnoreCase(confirm)) throw new Exception("Les mots des passes ne sont pas identiques.");
                } catch (Exception e){
                    alert(e.getMessage());
                    return;
                }

                final User user = new User(pseudo, mail);
                user.accountExist(activity, new CustomCallback() {
                    @Override
                    public void run() {
                        // Account doesn't exist
                        // Creating user
                        user.create(activity, password, new CustomCallback() {
                            @Override
                            public void run() {
                                // User created
                                runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        SharedPreferences settings = getSharedPreferences(PREF_USER, 0);
                                        SharedPreferences.Editor editor = settings.edit();
                                        editor.putString("pseudo", user.getPseudo());
                                        editor.putString("mail", user.getMail());
                                        editor.apply();

                                        Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                                        startActivity(githubActivity);
                                        finish();
                                    }
                                });
                            }
                        });
                    }
                }, new CustomCallback() {
                    @Override
                    public void run() {
                        alert("L'identifiant est déjà renseigné pour un compte existant.");
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
    public void alert(final String msg){
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                Toast.makeText(activity.getApplicationContext(), msg, Toast.LENGTH_LONG).show();
            }
        });
    }

    /**
     * Check if a string is an email address or not
     * @param email string to analyse
     * @return boolean
     */
    public static boolean isEmail(String email)
    {
        String emailRegex =
                "^[a-zA-Z0-9_+&*-]+(?:\\." +
                "[a-zA-Z0-9_+&*-]+)*@" +
                "(?:[a-zA-Z0-9-]+\\.)+[a-z" +
                "A-Z]{2,7}$";
        Pattern pat = Pattern.compile(emailRegex);
        if (email == null) return false;
        return pat.matcher(email).matches();
    }
}