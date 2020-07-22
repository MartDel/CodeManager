package fr.martdel.codemanagermobile.adapters;

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

public class CommitAdapter extends BaseAdapter {

    private Context context;
    private JSONArray commits;
    private LayoutInflater inflater;

    public CommitAdapter(Context context, JSONArray commits) {
        this.context = context;
        this.commits = commits;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return commits.length();
    }

    @Override
    public Commit getItem(int position) {
        try {
            JSONObject commit = commits.getJSONObject(position);
            String message = commit.getString("message");
            String author = commit.getString("author");
            String date = commit.getString("date");
            boolean last = commit.getBoolean("last");
            return new Commit(message, author, date, last);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View view, ViewGroup viewGroup) {
        view = inflater.inflate((R.layout.adapter_commit), null);

        Commit currentCommit = getItem(position);
        String commitMessage = currentCommit.getMessage();
        String commitAuthor = currentCommit.getAuthor();
        String commitDate = currentCommit.getDate();

        TextView commitMessageView = view.findViewById(R.id.message);
        commitMessageView.setText(commitMessage);

        TextView commitAuthorView = view.findViewById(R.id.author);
        commitAuthorView.setText(commitAuthor);

        TextView commitDateView = view.findViewById(R.id.date);
        commitDateView.setText(commitDate);

        if(currentCommit.getLast()){
            ImageView commitIconView = view.findViewById(R.id.commit_icon);
            commitIconView.setImageResource(R.drawable.start_commit_icon);
        }

        return view;
    }
}
