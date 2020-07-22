package fr.martdel.codemanagermobile;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;

public abstract class Internet {

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

    public static void errorConnection(AppCompatActivity activity){
        Toast.makeText(activity.getApplicationContext(), "Vous n'êtes pas connecté à Internet.", Toast.LENGTH_SHORT).show();
    }

}
