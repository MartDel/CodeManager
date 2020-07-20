package fr.martdel.codemanagermobile;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public abstract class Internet {

    public static boolean isOnline(AppCompatActivity activity) {
        ConnectivityManager cm = (ConnectivityManager) activity.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        if (netInfo != null && netInfo.isConnectedOrConnecting()) {
            return true;
        } else {
            return false;
        }
    }

    public static void errorConnection(AppCompatActivity activity){
        Toast.makeText(activity.getApplicationContext(), "Vous n'êtes pas connecté à Internet.", Toast.LENGTH_SHORT).show();
    }

}
