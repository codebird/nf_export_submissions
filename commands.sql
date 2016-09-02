INSERT INTO wp_objectmeta (object_id, meta_key, meta_value) VALUES (YOUR_FORM_ID, 'last_sub', 0);

CREATE TABLE `new_subs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `sub_id` int(11) DEFAULT NULL,
  `processed` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `processed` (`sent`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;