
plugin.tx_geoiphandler_geoiphandler {
    settings {
        redirects {
               fr {
                 target = https://fr.mydomain.com
                 trigger = in
               }
               jp{
                 target = https://jp.mydomain.com
                 trigger = in
               }
           }
    }
}
