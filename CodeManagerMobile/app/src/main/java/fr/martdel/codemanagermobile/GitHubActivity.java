package fr.martdel.codemanagermobile;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONException;

import fr.martdel.codemanagermobile.adapters.CommitAdapter;

public class GitHubActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_git_hub);
        Intent intent = getIntent();
        this.activity = this;

        try {
            String commits_str = intent.getStringExtra("commits");
            JSONArray commits = new JSONArray(commits_str);
            ListView commitsListView = findViewById(R.id.listCommit);
            commitsListView.setAdapter(new CommitAdapter(this, commits));
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}