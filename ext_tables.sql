#
# Table structure for table 'tx_geoiphandler_domain_model_redirect'
#
CREATE TABLE tx_geoiphandler_domain_model_redirect (
	isocode varchar(255) DEFAULT '' NOT NULL,
	target varchar(2048) DEFAULT '' NOT NULL,
	trigger varchar(2048) DEFAULT '' NOT NULL
);
