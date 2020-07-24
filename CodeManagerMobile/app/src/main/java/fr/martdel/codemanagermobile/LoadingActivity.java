package fr.martdel.codemanagermobile;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.animation.AlphaAnimation;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import fr.martdel.codemanagermobile.adapters.CommitAdapter;
import fr.martdel.codemanagermobile.models.Commit;
import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

// First activity
public class LoadingActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    private LinearLayout loadingLayout;
    private ProgressBar loadingProgress;
    private TextView loadingText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_loading);
        this.activity = this;

        this.loadingLayout = findViewById(R.id.loading_layout);
        this.loadingProgress = findViewById(R.id.loading_progress);
        this.loadingText = findViewById(R.id.loading_text);

        loadingProgress.setAlpha(0);
        loadingText.setAlpha(0);

        // Check connection
        final boolean connected = false;

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
                    // Check internet connection
                    if(!Internet.isOnline(activity)){
                        Internet.errorConnectionPopUp(activity);
                        return;
                    }

                    AlphaAnimation animationText = new AlphaAnimation(0f, 1f);
                    animationText.setDuration(1000);
                    loadingText.setAlpha(1);
                    loadingText.startAnimation(animationText);

                    Intent githubActivity = new Intent(getApplicationContext(), GitHubActivity.class);
                    // githubActivity.putExtra("commits", Commit.serializeListToJSON(commits));
                    startActivity(githubActivity);
                    finish();
                } else {
                    Intent mainActivity = new Intent(getApplicationContext(), MainActivity.class);
                    startActivity(mainActivity);
                    finish();
                }
            }
        }, 4000);
    }
}