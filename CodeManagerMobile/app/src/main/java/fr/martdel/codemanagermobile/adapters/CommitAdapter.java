package fr.martdel.codemanagermobile.adapters;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

import fr.martdel.codemanagermobile.R;
import fr.martdel.codemanagermobile.models.Commit;
import fr.martdel.codemanagermobile.popups.CommitPopup;

public class CommitAdapter extends BaseAdapter {

    private Activity activity;
    private JSONArray commitsJSON = null;
    private List<Commit> commitsList = null;
    private LayoutInflater inflater;

    public CommitAdapter(Activity activity, JSONArray commits) {
        this.activity = activity;
        this.commitsJSON = commits;
        this.inflater = LayoutInflater.from(activity);
    }

    public CommitAdapter(Activity activity, List<Commit> commits) {
        this.activity = activity;
        this.commitsList = commits;
        this.inflater = LayoutInflater.from(activity);
    }

    @Override
    public int getCount() {
        if(commitsJSON != null){
            return commitsJSON.length();
        } else {
            return commitsList.size();
        }
    }

    @Override
    public Commit getItem(int position) {
        if(commitsJSON != null){
            try {
                JSONObject commit = commitsJSON.getJSONObject(position);
                String sha = commit.getString("sha");
                String message = commit.getString("message");
                String author = commit.getString("author");
                String date = commit.getString("date");
                boolean last = commit.getBoolean("last");
                return new Commit(sha, message, author, date, last);
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return null;
        } else {
            return commitsList.get(position);
        }
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View view, ViewGroup viewGroup) {
        view = inflater.inflate((R.layout.adapter_commit), null);

        Commit currentCommit = getItem(position);
        final String commitSha = currentCommit.getSha();
        final String commitMessage = currentCommit.getMessage();
        final String commitAuthor = currentCommit.getAuthor();
        final String commitDate = currentCommit.getDate();

        TextView commitMessageView = view.findViewById(R.id.message);
        commitMessageView.setText(commitMessage);

        TextView commitAuthorView = view.findViewById(R.id.author);
        commitAuthorView.setText(commitAuthor);

        TextView commitDateView = view.findViewById(R.id.date);
        commitDateView.setText(commitDate);

        view.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final CommitPopup popup = new CommitPopup(activity);
                popup.setSha(commitSha);
                popup.setMessage(commitMessage);
                popup.setAuthor(commitAuthor);
                popup.setDate(commitDate);
                popup.getCloseBtn().setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        popup.dismiss();
                    }
                });
                popup.build();
            }
        });

        if(currentCommit.getLast()){
            ImageView commitIconView = view.findViewById(R.id.commit_icon);
            commitIconView.setImageResource(R.drawable.start_commit_icon);
        }

        return view;
    }
}
