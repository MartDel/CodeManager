package fr.martdel.codemanagermobile;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageView;

import androidx.appcompat.app.AppCompatActivity;

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

                Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                startActivity(githubActivity);
                finish();
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