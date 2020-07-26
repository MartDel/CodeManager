package fr.martdel.codemanagermobile.models;

public class User {

    private String pseudo;
    private String mail;

    public User(String pseudo, String mail) {
        this.pseudo = pseudo;
        this.mail = mail;
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
