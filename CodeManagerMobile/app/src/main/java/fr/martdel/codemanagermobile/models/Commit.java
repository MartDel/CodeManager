package fr.martdel.codemanagermobile.models;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

public class Commit {

    private String message;
    private String author;
    private String date;
    private boolean last;

    public Commit(String message, String author, String date, boolean last){
        this.message = message;
        this.author = author;
        this.date = date;
        this.last = last;
    }

    /**
     * Serialize the commit object to a JSON string
     * @return JSON string
     */
    public String serializetoJSON(){
        String commit =
        "{" +
            "message:\"" + message + "\"" +
            ",author:\"" + author + "\"" +
            ",date:\"" + date + "\"" +
            ",last:" + last +
        "}";
        return commit;
    }

    /**
     * Serialize all of Commit items in an ArrayList
     * @param list List to serialize
     * @return JSON string
     */
    public static String serializeListToJSON(List<Commit> list){
        String json = "[";
        for(int i = 0; i < list.size(); i++){
            Commit commit = list.get(i);
            json = json + commit.serializetoJSON();
            if(i != (list.size() - 1)) json = json + ",";
        }
        return json + "]";
    }

    public String getMessage() {
        return message;
    }

    public String getAuthor() {
        return author;
    }

    public String getDate() {
        String final_date = date;
        try {
            SimpleDateFormat parser = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");
            Date date = parser.parse(this.date);
            SimpleDateFormat formatter = new SimpleDateFormat("HH:mm:ss dd-MM-yyyy");
            final_date = formatter.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        return final_date;
    }

    public boolean getLast() {
        return last;
    }
}
