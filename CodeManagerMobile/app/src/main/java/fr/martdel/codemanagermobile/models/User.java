package fr.martdel.codemanagermobile.models;

import androidx.appcompat.app.AppCompatActivity;

import org.jetbrains.annotations.NotNull;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.Response;

public class User {

    private String pseudo;
    private String mail;

    public User(String pseudo, String mail) {
        this.pseudo = pseudo;
        this.mail = mail;
    }

    /**
     * Create the user in the database, push the user's info to the DB
     * @param activity Current activity
     * @param password User's password
     * @param callback Callback to execute when the user is created
     */
    public void create(final AppCompatActivity activity, String password, final CustomCallback callback) {
        JSONObject body = new JSONObject();
        try {
            body.put("table", "users");
            JSONObject user = new JSONObject();
            user.put("pseudo", pseudo);
            user.put("mail", mail);
            user.put("password", password);
            body.put("data", user);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Internet.doAPIRequest("POST", body, "", new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                Internet.errorRequestPopUp(activity);
            }

            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) {
                callback.run();
            }
        });
    }

    /**
     * Check if a user does exist or not
     * @param activity Current activity
     * @param doesntExist Callback to execute if the account doesn't exist
     * @param doesExist Callback to execute if the account does exist
     */
    public void accountExist(final AppCompatActivity activity, final CustomCallback doesntExist, final CustomCallback doesExist) {
        JSONObject body = new JSONObject();
        try {
            body.put("table", "users");
            JSONArray infos = new JSONArray();

            JSONObject pseudo_info = new JSONObject();
            pseudo_info.put("key", "pseudo");
            pseudo_info.put("value", pseudo);

            infos.put(pseudo_info);
            body.put("where", infos);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Internet.doAPIRequest("GET", body, null, new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                Internet.errorRequestPopUp(activity);
            }

            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) {
                try {
                    JSONArray resp = new JSONArray(response.body().string());
                    if(resp.length() == 0){
                        // Pseudo didn't be found in the DB
                        JSONObject body = new JSONObject();
                        try {
                            body.put("table", "users");
                            JSONArray infos = new JSONArray();

                            JSONObject mail_info = new JSONObject();
                            mail_info.put("key", "mail");
                            mail_info.put("value", mail);

                            infos.put(mail_info);
                            body.put("where", infos);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                        Internet.doAPIRequest("GET", body, null, new Callback() {
                            @Override
                            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                                Internet.errorRequestPopUp(activity);
                            }

                            @Override
                            public void onResponse(@NotNull Call call, @NotNull Response response) {
                                try {
                                    JSONArray resp = new JSONArray(response.body().string());
                                    if(resp.length() == 0){
                                        // E-mail address didn't be found in the DB
                                        // Account doesn't exist
                                        doesntExist.run();
                                    } else {
                                        // Account already exists
                                        doesExist.run();
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                } catch (IOException e) {
                                    e.printStackTrace();
                                }
                            }
                        });
                    } else {
                        // Account already exists
                        doesExist.run();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        });
    }

    public String getPseudo() {
        return pseudo;
    }

    public void setPseudo(String pseudo) {
        this.pseudo = pseudo;
    }

    public String getMail() {
        return mail;
    }

    public void setMail(String mail) {
        this.mail = mail;
    }
}
