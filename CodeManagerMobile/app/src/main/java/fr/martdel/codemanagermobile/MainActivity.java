package fr.martdel.codemanagermobile;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    private Button signinBtn, signupBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        this.activity = this;

        this.signinBtn = findViewById(R.id.signinBtn);
        signinBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!Internet.isOnline(activity)){
                    Internet.errorConnection(activity);
                    return;
                }
                Intent signinActivity = new Intent(getApplicationContext(), SigninActivity.class);
                startActivity(signinActivity);
                finish();
            }
        });

        this.signupBtn = findViewById(R.id.signupBtn);
        signupBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!Internet.isOnline(activity)){
                    Internet.errorConnection(activity);
                    return;
                }
                Intent signupActivity = new Intent(getApplicationContext(), SignupActivity.class);
                startActivity(signupActivity);
                finish();
            }
        });
    }
}