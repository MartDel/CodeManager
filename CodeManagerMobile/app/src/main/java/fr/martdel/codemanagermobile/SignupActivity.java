package fr.martdel.codemanagermobile;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;

public class SignupActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    private EditText pseudoView, mailView;
    private EditText passwordView, confirmPasswordView;
    private Button submitBtn;

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

        submitBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // User sign up
                if(!Internet.isOnline(activity)){
                    Internet.errorConnection(activity);
                    return;
                }
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