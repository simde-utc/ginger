<?php

class Config {
    // URL vers l'API Accounts UTC (avec le / final)
    public static $ACCOUNTS_URL = "http://localhost/accounts/";
    // Choix du backend pour accounts
    //      - accounts: connection direct
    //      - ginger: connection à un autre ginger
    public static $ACCOUNTS_BACKEND = "accounts";
    // clef d'application du ginger distant
    public static $REMOTE_GINGER_KEY = "fauxginger";
    // timeout pour l'appel au ginger distant
    public static $REMOTE_GINGER_TIMEOUT = 0.2;
    // If false, then ginger skip the call to account on card lookup if the user is already in database
    public static $REFRESH_ON_CARD_LOOKUP = true;
}
