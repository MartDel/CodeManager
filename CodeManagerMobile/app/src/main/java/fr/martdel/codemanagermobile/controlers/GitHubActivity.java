package fr.martdel.codemanagermobile.controlers;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.ProgressBar;

import androidx.appcompat.app.AppCompatActivity;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import fr.martdel.codemanagermobile.R;
import fr.martdel.codemanagermobile.adapters.CommitAdapter;
import fr.martdel.codemanagermobile.models.Commit;
import fr.martdel.codemanagermobile.models.Internet;
import fr.martdel.codemanagermobile.models.User;
import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

public class GitHubActivity extends AppCompatActivity {

    public static final String PREF_USER = "UsersPreferences";
    private AppCompatActivity activity;

    private ProgressBar loading;
    private ListView commitsListView;

    private User current_user;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_git_hub);
        this.activity = this;
        this.loading = findViewById(R.id.loading);
        this.commitsListView = findViewById(R.id.listCommit);

        // Get current user
        SharedPreferences settings = getSharedPreferences(PREF_USER, 0);
        String pseudo = settings.getString("pseudo", getResources().getString(R.string.pseudo_default));
        String mail = settings.getString("mail", getResources().getString(R.string.mail_default));
        this.current_user = new User(pseudo, mail);

        Internet.doGetRequest("https://api.github.com/repos/MartDel/CodeManager/commits", new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                Internet.errorRequestPopUp(activity);
            }
            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                final List<Commit> commits = new ArrayList<>();

                try {
                    JSONArray data = new JSONArray(response.body().string());
                    for(int i = 0; i < data.length(); i++){
                        JSONObject current_commit = data.getJSONObject(i);
                        JSONObject commit = current_commit.getJSONObject("commit");
                        String commitSha = current_commit.getString("sha");
                        String commitMessage = commit.getString("message");
                        String commitAuthor = commit.getJSONObject("author").getString("name");
                        String commitDate = commit.getJSONObject("author").getString("date");

                        boolean last = false;
                        if(i == 0) last = true;

                        Commit currentCommit = new Commit(commitSha.substring(0, 7), commitMessage, commitAuthor, commitDate, last);
                        commits.add(currentCommit);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                activity.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        ((ViewGroup) loading.getParent()).removeView(loading);
                        commitsListView.setAdapter(new CommitAdapter(activity, commits));
                    }
                });
            }
        });
    }
}