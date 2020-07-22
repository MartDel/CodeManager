package fr.martdel.codemanagermobile.models;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Commit {

    private String message;
    private String author;
    private String date;

    public Commit(String message, String author, String date_str){
        this.message = message;
        this.author = author;
        String final_date = null;
        try {
            SimpleDateFormat parser = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");
            Date date = parser.parse(date_str);
            SimpleDateFormat formatter = new SimpleDateFormat("HH:mm:ss dd-MM-yyyy");
            final_date = formatter.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        this.date = final_date;
    }

    public String getMessage() {
        return message;
    }

    public String getAuthor() {
        return author;
    }

    public String getDate() {
        return date;
    }
}
