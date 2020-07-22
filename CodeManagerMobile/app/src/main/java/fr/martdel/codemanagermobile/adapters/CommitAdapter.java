package fr.martdel.codemanagermobile.adapters;

import android.annotation.SuppressLint;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.List;

import fr.martdel.codemanagermobile.R;
import fr.martdel.codemanagermobile.models.Commit;

public class CommitAdapter extends BaseAdapter {

    private Context context;
    private List<Commit> commits;
    private LayoutInflater inflater;

    public CommitAdapter(Context context, List<Commit> commits) {
        this.context = context;
        this.commits = commits;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return commits.size();
    }

    @Override
    public Commit getItem(int position) {
        return commits.get(position);
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
        System.out.println(commitMessageView.getLineCount());

        TextView commitAuthorView = view.findViewById(R.id.author);
        commitAuthorView.setText(commitAuthor);

        TextView commitDateView = view.findViewById(R.id.date);
        commitDateView.setText(commitDate);

        return view;
    }
}
