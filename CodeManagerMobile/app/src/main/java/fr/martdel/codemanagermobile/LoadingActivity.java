package fr.martdel.codemanagermobile;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.animation.AlphaAnimation;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

// First activity
public class LoadingActivity extends AppCompatActivity {

    private LinearLayout loadingLayout;
    private ProgressBar loadingProgress;
    private TextView loadingText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_loading);

        this.loadingLayout = findViewById(R.id.loading_layout);
        this.loadingProgress = findViewById(R.id.loading_progress);
        this.loadingText = findViewById(R.id.loading_text);

        loadingProgress.setAlpha(0);
        loadingText.setAlpha(0);

        // Check connection
        final boolean connected = true;

        AlphaAnimation animationLayout = new AlphaAnimation(0f, 1f);
        animationLayout.setDuration(2000);
        loadingLayout.startAnimation(animationLayout);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                AlphaAnimation animationProgress = new AlphaAnimation(0f, 1f);
                animationProgress.setDuration(500);
                loadingProgress.setAlpha(1);
                loadingProgress.startAnimation(animationProgress);
            }
        }, 2000);

        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                if(connected){
                    AlphaAnimation animationText = new AlphaAnimation(0f, 1f);
                    animationText.setDuration(1000);
                    loadingText.setAlpha(1);
                    loadingText.startAnimation(animationText);

                    // Check internet connection
                    new Handler().postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                            startActivity(githubActivity);
                            finish();
                        }
                    }, 1000);
                } else {
                    Intent mainActivity = new Intent(getApplicationContext(), MainActivity.class);
                    startActivity(mainActivity);
                    finish();
                }
            }
        }, 4000);
    }
}