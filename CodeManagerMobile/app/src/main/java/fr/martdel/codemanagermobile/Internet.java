package fr.martdel.codemanagermobile;

import android.content.Context;
import android.content.DialogInterface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;

public abstract class Internet {

    /**
     * Check if internet connection is available
     * @param activity Current activity
     * @return boolean if internet is available return true
     */
    public static boolean isOnline(AppCompatActivity activity) {
        /*ConnectivityManager cm = (ConnectivityManager) activity.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        if (netInfo != null && netInfo.isConnectedOrConnecting()) {
            return true;
        } else {
            return false;
        }*/

        ConnectivityManager connectivityManager = (ConnectivityManager) activity.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo info = connectivityManager.getActiveNetworkInfo();
        if (info == null || !info.isConnected() || !info.isAvailable()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Do a HTTP GET request
     * @param target Url to request
     * @param callback Function to execute when we get response
     */
    public static void doGetRequest(String target, Callback callback){
        try{
            OkHttpClient client = new OkHttpClient();
            Request request = new Request.Builder()
                    .url(target)
                    .method("GET", null)
                    .addHeader("Cache-Control", "no-cache")
                    .addHeader("User-Agent", "martdel")
                    .build();
            client.newCall(request).enqueue(callback);
        } catch (Exception e){
            System.out.println("ERROR");
            System.out.println(e.getMessage());
        }
    }

    /**
     * Show an error message about no connection
     * @param activity
     */
    public static void errorConnection(AppCompatActivity activity){
        Toast.makeText(activity.getApplicationContext(), "Vous n'êtes pas connecté à Internet.", Toast.LENGTH_SHORT).show();
    }

    /**
     * Show an error popup about no connection
     * @param activity
     */
    public static void errorConnectionPopUp(final AppCompatActivity activity){
        AlertDialog.Builder alert = new AlertDialog.Builder(activity);
        alert.setTitle("Pas de connexion Internet !");
        alert.setMessage("Un problème est survenu lors de la connexion. Veuillez vérifier votre connexion Internet puis réessayer.");
        alert.setNegativeButton("QUITTER", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                activity.finish();
            }
        });
        alert.show();
    }

    /**
     * Show an error popup about request failed
     * @param activity
     */
    public static void errorRequestPopUp(final AppCompatActivity activity){
        AlertDialog.Builder alert = new AlertDialog.Builder(activity);
        alert.setTitle("Un problème est survenu !");
        alert.setMessage("Un problème est survenu lors de la récupération des données. Veuillez vérifier votre connexion Internet puis réessayer.");
        alert.setNegativeButton("QUITTER", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                activity.finish();
            }
        });
        alert.show();
    }
}
