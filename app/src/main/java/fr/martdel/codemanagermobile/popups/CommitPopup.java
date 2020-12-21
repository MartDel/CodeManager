package fr.martdel.codemanagermobile.popups;

import android.app.Dialog;
import android.content.Context;
import android.widget.Switch;
import android.widget.TextView;

import androidx.annotation.NonNull;

import fr.martdel.codemanagermobile.R;

public class CommitPopup extends Dialog {

    private String sha, message, author, date;
    private TextView shaView, messageView, authorView, dateView;
    private Switch objectiveBtn, taskBtn;
    private TextView closeBtn;

    public CommitPopup(@NonNull Context context) {
        super(context, R.style.Theme_AppCompat_DayNight_Dialog);
        setContentView(R.layout.commit_popup);

        this.sha = context.getResources().getString(R.string.commit_sha_default);
        this.message = context.getResources().getString(R.string.commit_msg_default);
        this.author = context.getResources().getString(R.string.commit_author_default);
        this.date = context.getResources().getString(R.string.commit_date_default);

        this.shaView = findViewById(R.id.sha);
        this.messageView = findViewById(R.id.message);
        this.authorView = findViewById(R.id.author);
        this.dateView = findViewById(R.id.date);

        this.objectiveBtn = findViewById(R.id.objective_btn);
        this.taskBtn = findViewById(R.id.task_btn);
        this.closeBtn = findViewById(R.id.close_btn);
    }

    public void build(){
        show();
        shaView.setText(sha);
        messageView.setText(message);
        authorView.setText(author);
        dateView.setText(date);
    }

    public void setSha(String sha) {
        this.sha = sha;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public void setAuthor(String author) {
        this.author = author;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public Switch getObjectiveBtn() {
        return objectiveBtn;
    }

    public Switch getTaskBtn() {
        return taskBtn;
    }

    public TextView getCloseBtn() {
        return closeBtn;
    }
}
