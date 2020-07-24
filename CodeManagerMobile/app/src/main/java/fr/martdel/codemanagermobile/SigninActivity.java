package fr.martdel.codemanagermobile;

import android.content.Intent;
import android.os.Bundle;
import android.util.JsonToken;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageView;

import androidx.appcompat.app.AppCompatActivity;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

public class SigninActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    private EditText loginView, passwordView;
    private CheckBox keepConnectedView;
    private Button submitBtn;
    private ImageView homeBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signin);
        this.activity = this;

        this.loginView = findViewById(R.id.loginInput);
        this.passwordView = findViewById(R.id.passwordInput);
        this.keepConnectedView = findViewById(R.id.keepConnectedCheckBox);
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

                JSONObject body = new JSONObject();
                try {
                    body.put("table", "users");

                    JSONArray wheres = new JSONArray();

                    JSONObject where1 = new JSONObject();
                    where1.put("key", "pseudo");
                    where1.put("value", "MartDel");

                    wheres.put(where1);

                    body.put("where", wheres);
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
                        System.out.println(response.body().string());
                    }
                });

                /*Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                startActivity(githubActivity);
                finish();*/
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
}