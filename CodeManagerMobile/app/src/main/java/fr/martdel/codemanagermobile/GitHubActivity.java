package fr.martdel.codemanagermobile;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.ConstraintSet;

import android.os.Bundle;
import android.text.Layout;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.List;

import fr.martdel.codemanagermobile.adapters.CommitAdapter;
import fr.martdel.codemanagermobile.models.Commit;
import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

public class GitHubActivity extends AppCompatActivity {

    private AppCompatActivity activity;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_git_hub);
        this.activity = this;

        Internet.doGetRequest("https://api.github.com/repos/MartDel/CodeManager/commits", new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                System.out.println("Error...");
            }
            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                final List<Commit> commits = new ArrayList<>();

                try {
                    JSONArray data = new JSONArray(response.body().string());
                    for(int i = 0; i < data.length(); i++){
                        JSONObject commit = data.getJSONObject(i).getJSONObject("commit");
                        String commitMessage = commit.getString("message");
                        String commitAuthor = commit.getJSONObject("author").getString("name");
                        String commitDate = commit.getJSONObject("author").getString("date");

                        Commit currentCommit = new Commit(commitMessage, commitAuthor, commitDate);
                        commits.add(currentCommit);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                activity.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        ListView listCommit = findViewById(R.id.listCommit);
                        listCommit.setAdapter(new CommitAdapter(activity, commits));
                    }
                });
            }
        });
    }
}