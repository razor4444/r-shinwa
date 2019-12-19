-- phpMyAdmin SQL Dump

CREATE TABLE `xpweather_userloc` (
  `userid` int(11) NOT NULL default '0',
  `wcid` varchar(8) NOT NULL default '',
  `tpc` tinyint(1) NOT NULL default '0',
  `tps` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (userid),
  KEY wcid (wcid)
) TYPE=MyISAM;

INSERT INTO `xpweather_userloc` VALUES (0, 'JAXX0085', 0, 0);

CREATE TABLE `xpweather_country` (
  `reg_id` int(11) NOT NULL default '0',
  `ctry_id` int(11) NOT NULL default '0',
  `sign` varchar(10) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ctry_id`)
) TYPE=MyISAM;

INSERT INTO `xpweather_country` VALUES (1, 1, 'AG', 'Algeria'),
(1, 2, 'AO', 'Angola'),
(1, 3, 'BC', 'Botswana'),
(1, 4, 'BN', 'Benin'),
(1, 5, 'BY', 'Burundi'),
(1, 6, 'CD', 'Chad'),
(1, 7, 'CF', 'Republic of The Congo'),
(1, 8, 'CG', 'Democratic Republic of The Congo'),
(1, 9, 'CM', 'Cameroon'),
(1, 10, 'CN', 'Comoros'),
(1, 11, 'CT', 'Central African Republic'),
(1, 12, 'CV', 'Cape Verde'),
(1, 13, 'DJ', 'Djibouti'),
(1, 14, 'EG', 'Egypt'),
(1, 15, 'EK', 'Equatorial Guinea'),
(1, 16, 'ER', 'Eritrea'),
(1, 17, 'ET', 'Ethiopia'),
(1, 18, 'GA', 'The Gambia'),
(1, 19, 'GB', 'Gabon'),
(1, 20, 'GH', 'Ghana'),
(1, 21, 'GV', 'Guinea'),
(1, 22, 'IV', 'Cote D'' Ivoire'),
(1, 23, 'KE', 'Kenya'),
(1, 24, 'LI', 'Liberia'),
(1, 25, 'LT', 'Lesotho'),
(1, 26, 'LY', 'Libya'),
(1, 27, 'MA', 'Madagascar'),
(1, 28, 'MF', 'Mayotte'),
(1, 29, 'MI', 'Malawi'),
(1, 30, 'ML', 'Mali'),
(1, 31, 'MO', 'Morocco'),
(1, 32, 'MP', 'Mauritius'),
(1, 33, 'MR', 'Mauritania'),
(1, 34, 'MZ', 'Mozambique'),
(1, 35, 'NG', 'Niger'),
(1, 36, 'NI', 'Nigeria'),
(1, 37, 'PU', 'Guinea-bissau'),
(1, 38, 'RE', 'Reunion'),
(1, 39, 'RW', 'Rwanda'),
(1, 40, 'SE', 'Seychelles'),
(1, 41, 'SF', 'South Africa'),
(1, 42, 'SG', 'Senegal'),
(1, 43, 'SH', 'St. Helena'),
(1, 44, 'SL', 'Sierra Leone'),
(1, 45, 'SO', 'Somalia'),
(1, 46, 'SU', 'Sudan'),
(1, 47, 'TO', 'Togo'),
(1, 48, 'TP', 'Sao Tome and Principe'),
(1, 49, 'TS', 'Tunisia'),
(1, 50, 'TZ', 'United Republic of Tanzania'),
(1, 51, 'UG', 'Uganda'),
(1, 52, 'UV', 'Burkina Faso'),
(1, 53, 'WA', 'Namibia'),
(1, 54, 'WI', 'Western Sahara'),
(1, 55, 'WZ', 'Swaziland'),
(1, 56, 'ZA', 'Zambia'),
(1, 57, 'ZI', 'Zimbabwe'),
(2, 58, 'AY', 'Antarctica'),
(3, 59, 'AE', 'United Arab Emirates'),
(3, 60, 'AF', 'Afghanistan'),
(3, 61, 'AJ', 'Azerbaijan'),
(3, 62, 'AM', 'Armenia'),
(3, 63, 'BA', 'Bahrain'),
(3, 64, 'BG', 'Bangladesh'),
(3, 65, 'BM', 'Burma'),
(3, 66, 'BP', 'Solomon Islands'),
(3, 67, 'BT', 'Bhutan'),
(3, 68, 'BX', 'Brunei'),
(3, 69, 'CB', 'Cambodia'),
(3, 70, 'CE', 'Sri Lanka'),
(3, 71, 'CH', 'China'),
(3, 72, 'CY', 'Cyprus'),
(3, 73, 'FJ', 'Fiji'),
(3, 74, 'GG', 'Georgia'),
(3, 75, 'ID', 'Indonesia'),
(3, 76, 'IN', 'India'),
(3, 77, 'IR', 'Iran'),
(3, 78, 'IS', 'Israel'),
(3, 79, 'IZ', 'Iraq'),
(3, 80, 'JA', 'Japan'),
(3, 81, 'JO', 'Jordan'),
(3, 82, 'KG', 'Kyrgyzstan'),
(3, 83, 'KN', 'North Korea'),
(3, 84, 'KR', 'Kiribati'),
(3, 85, 'KS', 'South Korea'),
(3, 86, 'KU', 'Kuwait'),
(3, 87, 'KZ', 'Kazakhstan'),
(3, 88, 'LA', 'Laos'),
(3, 89, 'LE', 'Lebanon'),
(3, 90, 'MG', 'Mongolia'),
(3, 91, 'MU', 'Oman'),
(3, 92, 'MY', 'Malaysia'),
(3, 93, 'NC', 'New Caledonia'),
(3, 94, 'NH', 'Vanuatu'),
(3, 95, 'NP', 'Nepal'),
(3, 96, 'PK', 'Pakistan'),
(3, 97, 'PP', 'Papua New Guinea'),
(3, 98, 'QA', 'Qatar'),
(3, 99, 'RP', 'Philippines'),
(3, 100, 'RS', 'Russia'),
(3, 101, 'SA', 'Saudi Arabia'),
(3, 102, 'SN', 'Singapore'),
(3, 103, 'SY', 'Syria'),
(3, 104, 'TH', 'Thailand'),
(3, 105, 'TI', 'Tajikistan'),
(3, 106, 'TU', 'Turkey'),
(3, 107, 'TW', 'Taiwan'),
(3, 108, 'TX', 'Turkmenistan'),
(3, 109, 'UZ', 'Uzbekistan'),
(3, 110, 'VM', 'Vietnam'),
(3, 111, 'WE', 'West Bank'),
(3, 112, 'YM', 'Yemen'),
(4, 113, 'AS', 'Australia'),
(5, 114, 'AO', 'Angola'),
(5, 115, 'BN', 'Benin'),
(5, 116, 'BY', 'Burundi'),
(5, 117, 'CF', 'Republic of The Congo'),
(5, 118, 'CG', 'Democratic Republic of The Congo'),
(5, 119, 'CM', 'Cameroon'),
(5, 120, 'CT', 'Central African Republic'),
(5, 121, 'CV', 'Cape Verde'),
(5, 122, 'EK', 'Equatorial Guinea'),
(5, 123, 'GA', 'The Gambia'),
(5, 124, 'GB', 'Gabon'),
(5, 125, 'GH', 'Ghana'),
(5, 126, 'GV', 'Guinea'),
(5, 127, 'IV', 'Cote D'' Ivoire'),
(5, 128, 'KE', 'Kenya'),
(5, 129, 'LI', 'Liberia'),
(5, 130, 'MI', 'Malawi'),
(5, 131, 'NI', 'Nigeria'),
(5, 132, 'PU', 'Guinea-bissau'),
(5, 133, 'RW', 'Rwanda'),
(5, 134, 'SG', 'Senegal'),
(5, 135, 'SL', 'Sierra Leone'),
(5, 136, 'TO', 'Togo'),
(5, 137, 'TZ', 'United Republic of Tanzania'),
(5, 138, 'UG', 'Uganda'),
(5, 139, 'UV', 'Burkina Faso'),
(5, 140, 'ZA', 'Zambia'),
(6, 141, 'BH', 'Belize'),
(6, 142, 'CS', 'Costa Rica'),
(6, 143, 'ES', 'El Salvador'),
(6, 144, 'GT', 'Guatemala'),
(6, 145, 'HO', 'Honduras'),
(6, 146, 'MX', 'Mexico'),
(6, 147, 'NU', 'Nicaragua'),
(6, 148, 'PM', 'Panama'),
(7, 149, 'AA', 'Aruba'),
(7, 150, 'AC', 'Antigua and Barbuda'),
(7, 151, 'AV', 'Anguilla'),
(7, 152, 'BB', 'Barbados'),
(7, 153, 'BF', 'The Bahamas'),
(7, 154, 'CJ', 'Cayman Islands'),
(7, 155, 'CU', 'Cuba'),
(7, 156, 'DO', 'Dominica'),
(7, 157, 'DR', 'Dominican Republic'),
(7, 158, 'GJ', 'Grenada'),
(7, 159, 'GP', 'Guadeloupe'),
(7, 160, 'HA', 'Haiti'),
(7, 161, 'JM', 'Jamaica'),
(7, 162, 'MB', 'Martinique'),
(7, 163, 'NT', 'Netherlands Antilles'),
(7, 164, 'SC', 'St. Kitts and Nevis'),
(7, 165, 'ST', 'Saint Lucia'),
(7, 166, 'TD', 'Trinidad and Tobago'),
(7, 167, 'TK', 'Turks and Caicos Islands'),
(7, 168, 'VI', 'British Virgin Islands'),
(8, 169, 'AF', 'Afghanistan'),
(8, 170, 'AJ', 'Azerbaijan'),
(8, 171, 'AM', 'Armenia'),
(8, 172, 'BG', 'Bangladesh'),
(8, 173, 'BT', 'Bhutan'),
(8, 174, 'CE', 'Sri Lanka'),
(8, 175, 'CH', 'China'),
(8, 176, 'GG', 'Georgia'),
(8, 177, 'IN', 'India'),
(8, 178, 'KG', 'Kyrgyzstan'),
(8, 179, 'KZ', 'Kazakhstan'),
(8, 180, 'MV', 'Maldives'),
(8, 181, 'NP', 'Nepal'),
(8, 182, 'PK', 'Pakistan'),
(8, 183, 'RS', 'Russia'),
(8, 184, 'TI', 'Tajikistan'),
(8, 185, 'TX', 'Turkmenistan'),
(8, 186, 'UZ', 'Uzbekistan'),
(9, 187, 'AL', 'Albania'),
(9, 188, 'BK', 'Bosnia and Herzegovina'),
(9, 189, 'BO', 'Belarus'),
(9, 190, 'BU', 'Bulgaria'),
(9, 191, 'EN', 'Estonia'),
(9, 192, 'EZ', 'Czech Republic'),
(9, 193, 'GR', 'Greece'),
(9, 194, 'HR', 'Croatia'),
(9, 195, 'HU', 'Hungary'),
(9, 196, 'LG', 'Latvia'),
(9, 197, 'LH', 'Lithuania'),
(9, 198, 'LO', 'Slovakia'),
(9, 199, 'MD', 'Moldova'),
(9, 200, 'MK', 'Former Yugoslav Rep. of Macedonia'),
(9, 201, 'PL', 'Poland'),
(9, 202, 'RO', 'Romania'),
(9, 203, 'RS', 'Russia'),
(9, 204, 'SI', 'Slovenia'),
(9, 205, 'UP', 'Ukraine'),
(9, 206, 'YI', 'Yugoslavia'),
(10, 207, 'AL', 'Albania'),
(10, 208, 'AU', 'Austria'),
(10, 209, 'BE', 'Belgium'),
(10, 210, 'BK', 'Bosnia and Herzegovina'),
(10, 211, 'BO', 'Belarus'),
(10, 212, 'BU', 'Bulgaria'),
(10, 213, 'DA', 'Denmark'),
(10, 214, 'EI', 'Ireland'),
(10, 215, 'EN', 'Estonia'),
(10, 216, 'EZ', 'Czech Republic'),
(10, 217, 'FI', 'Finland'),
(10, 218, 'FR', 'France'),
(10, 219, 'GI', 'Gibraltar'),
(10, 220, 'GL', 'Greenland'),
(10, 221, 'GM', 'Germany'),
(10, 222, 'GR', 'Greece'),
(10, 223, 'HR', 'Croatia'),
(10, 224, 'HU', 'Hungary'),
(10, 225, 'IC', 'Iceland'),
(10, 226, 'IM', 'Isle of Man'),
(10, 227, 'IT', 'Italy'),
(10, 228, 'LG', 'Latvia'),
(10, 229, 'LH', 'Lithuania'),
(10, 230, 'LO', 'Slovakia'),
(10, 231, 'LS', 'Liechtenstein'),
(10, 232, 'MD', 'Moldova'),
(10, 233, 'MK', 'Former Yugoslav Rep. of Macedonia'),
(10, 234, 'MN', 'Monaco'),
(10, 235, 'NL', 'Netherlands'),
(10, 236, 'NO', 'Norway'),
(10, 237, 'PL', 'Poland'),
(10, 238, 'PO', 'Portugal'),
(10, 239, 'RO', 'Romania'),
(10, 240, 'RS', 'Russia'),
(10, 241, 'SI', 'Slovenia'),
(10, 242, 'SM', 'San Marino'),
(10, 243, 'SP', 'Spain'),
(10, 244, 'SW', 'Sweden'),
(10, 245, 'SZ', 'Switzerland'),
(10, 246, 'UK', 'United Kingdom'),
(10, 247, 'UP', 'Ukraine'),
(10, 248, 'YI', 'Yugoslavia'),
(12, 249, 'AE', 'United Arab Emirates'),
(12, 250, 'BA', 'Bahrain'),
(12, 251, 'CY', 'Cyprus'),
(12, 252, 'EG', 'Egypt'),
(12, 253, 'IR', 'Iran'),
(12, 254, 'IS', 'Israel'),
(12, 255, 'IZ', 'Iraq'),
(12, 256, 'JO', 'Jordan'),
(12, 257, 'KU', 'Kuwait'),
(12, 258, 'LE', 'Lebanon'),
(12, 259, 'MU', 'Oman'),
(12, 260, 'QA', 'Qatar'),
(12, 261, 'SA', 'Saudi Arabia'),
(12, 262, 'SY', 'Syria'),
(12, 263, 'TU', 'Turkey'),
(12, 264, 'WE', 'West Bank'),
(12, 265, 'YM', 'Yemen'),
(13, 266, 'AG', 'Algeria'),
(13, 267, 'CD', 'Chad'),
(13, 268, 'DJ', 'Djibouti'),
(13, 269, 'EG', 'Egypt'),
(13, 270, 'ER', 'Eritrea'),
(13, 271, 'ET', 'Ethiopia'),
(13, 272, 'LY', 'Libya'),
(13, 273, 'ML', 'Mali'),
(13, 274, 'MO', 'Morocco'),
(13, 275, 'MR', 'Mauritania'),
(13, 276, 'NG', 'Niger'),
(13, 277, 'SO', 'Somalia'),
(13, 278, 'SU', 'Sudan'),
(13, 279, 'TS', 'Tunisia'),
(13, 280, 'WI', 'Western Sahara'),
(14, 281, 'BD', 'Bermuda'),
(15, 282, 'BF', 'The Bahamas'),
(15, 283, 'BH', 'Belize'),
(15, 284, 'CA', 'Canada'),
(15, 285, 'CS', 'Costa Rica'),
(15, 286, 'ES', 'El Salvador'),
(15, 287, 'GT', 'Guatemala'),
(15, 288, 'HO', 'Honduras'),
(15, 289, 'MX', 'Mexico'),
(15, 290, 'NU', 'Nicaragua'),
(15, 291, 'PM', 'Panama'),
(16, 293, 'NZ', 'New Zealand'),
(18, 294, 'BC', 'Botswana'),
(18, 295, 'CN', 'Comoros'),
(18, 296, 'LT', 'Lesotho'),
(18, 297, 'MA', 'Madagascar'),
(18, 298, 'MP', 'Mauritius'),
(18, 299, 'MZ', 'Mozambique'),
(18, 300, 'RE', 'Reunion'),
(18, 301, 'SE', 'Seychelles'),
(18, 302, 'SF', 'South Africa'),
(18, 303, 'WA', 'Namibia'),
(18, 304, 'WZ', 'Swaziland'),
(18, 305, 'ZI', 'Zimbabwe'),
(19, 306, 'FK', 'Falkland Islands'),
(19, 307, 'SX', 'S. Georgia and S. Sandwich Islands'),
(20, 308, 'AR', 'Argentina'),
(20, 309, 'BL', 'Bolivia'),
(20, 310, 'BR', 'Brazil'),
(20, 311, 'CI', 'Chile'),
(20, 312, 'CO', 'Colombia'),
(20, 313, 'EC', 'Ecuador'),
(20, 314, 'FG', 'French Guiana'),
(20, 315, 'FK', 'Falkland Islands'),
(20, 316, 'GY', 'Guyana'),
(20, 317, 'NS', 'Suriname'),
(20, 318, 'PA', 'Paraguay'),
(20, 319, 'PE', 'Peru'),
(20, 320, 'UY', 'Uruguay'),
(20, 321, 'VE', 'Venezuela'),
(21, 322, 'DA', 'Denmark'),
(21, 323, 'FI', 'Finland'),
(21, 324, 'NO', 'Norway'),
(21, 325, 'SW', 'Sweden'),
(22, 326, 'BM', 'Burma'),
(22, 327, 'CB', 'Cambodia'),
(22, 328, 'CH', 'China'),
(22, 329, 'ID', 'Indonesia'),
(22, 330, 'KT', 'Christmas Island'),
(22, 331, 'LA', 'Laos'),
(22, 332, 'MY', 'Malaysia'),
(22, 333, 'PP', 'Papua New Guinea'),
(22, 334, 'RP', 'Philippines'),
(22, 335, 'TH', 'Thailand'),
(22, 336, 'TW', 'Taiwan'),
(22, 337, 'VM', 'Vietnam'),
(23, 338, 'GR', 'Greece'),
(23, 339, 'IT', 'Italy'),
(23, 340, 'MN', 'Monaco'),
(23, 341, 'MT', 'Malta'),
(23, 342, 'PO', 'Portugal'),
(23, 343, 'SM', 'San Marino'),
(23, 344, 'SP', 'Spain'),
(24, 345, 'US/AS', 'American Samoa'),
(24, 346, 'BP', 'Solomon Islands'),
(24, 347, 'CW', 'Cook Islands'),
(24, 348, 'FJ', 'Fiji'),
(24, 349, 'FP', 'French Polynesia'),
(24, 350, 'US/GU', 'Guam'),
(24, 351, 'KR', 'Kiribati'),
(24, 352, 'NC', 'New Caledonia'),
(24, 353, 'NH', 'Vanuatu'),
(24, 354, 'NR', 'Nauru'),
(24, 355, 'US/PW', 'Palau'),
(24, 356, 'PP', 'Papua New Guinea'),
(24, 357, 'US/MH', 'Marshall Islands'),
(24, 358, 'TN', 'Tonga'),
(24, 359, 'TV', 'Tuvalu'),
(24, 360, 'WS', 'Western Samoa'),
(25, 361, 'AN', 'Andorra'),
(25, 362, 'AU', 'Austria'),
(25, 363, 'BE', 'Belgium'),
(25, 364, 'DA', 'Denmark'),
(25, 365, 'EI', 'Ireland'),
(25, 366, 'FR', 'France'),
(25, 367, 'GI', 'Gibraltar'),
(25, 368, 'GM', 'Germany'),
(25, 369, 'IT', 'Italy'),
(25, 370, 'LS', 'Liechtenstein'),
(25, 371, 'LU', 'Luxembourg'),
(25, 372, 'MN', 'Monaco'),
(25, 373, 'NL', 'Netherlands'),
(25, 374, 'PO', 'Portugal'),
(25, 375, 'SP', 'Spain'),
(25, 376, 'SZ', 'Switzerland'),
(25, 377, 'UK', 'United Kingdom'),
(26, 378, 'US/AK', 'Alaska'),
(26, 379, 'US/AL', 'Alabama'),
(26, 380, 'US/AR', 'Arkansas'),
(26, 381, 'US/AS', 'American Samoa'),
(26, 382, 'US/AZ', 'Arizona'),
(26, 383, 'US/CA', 'California'),
(26, 384, 'US/CO', 'Colorado'),
(26, 385, 'US/CT', 'Connecticut'),
(26, 386, 'US/DC', 'District Of Columbia'),
(26, 387, 'US/DE', 'Delaware'),
(26, 388, 'US/FL', 'Florida'),
(26, 389, 'US/FM', 'Federated States Of Micronesia'),
(26, 390, 'US/GA', 'Georgia'),
(26, 391, 'US/GU', 'Guam'),
(26, 392, 'US/HI', 'Hawaii'),
(26, 393, 'US/IA', 'Iowa'),
(26, 394, 'US/ID', 'Idaho'),
(26, 395, 'US/IL', 'Illinois'),
(26, 396, 'US/IN', 'Indiana'),
(26, 397, 'US/KS', 'Kansas'),
(26, 398, 'US/KY', 'Kentucky'),
(26, 399, 'US/LA', 'Louisiana'),
(26, 400, 'US/MA', 'Massachusetts'),
(26, 401, 'US/MD', 'Maryland'),
(26, 402, 'US/ME', 'Maine'),
(26, 403, 'US/MH', 'Marshall Islands'),
(26, 404, 'US/MI', 'Michigan'),
(26, 405, 'US/MN', 'Minnesota'),
(26, 406, 'US/MO', 'Missouri'),
(26, 407, 'US/MP', 'Northern Mariana Islands'),
(26, 408, 'US/MS', 'Mississippi'),
(26, 409, 'US/MT', 'Montana'),
(26, 410, 'US/NC', 'North Carolina'),
(26, 411, 'US/ND', 'North Dakota'),
(26, 412, 'US/NE', 'Nebraska'),
(26, 413, 'US/NH', 'New Hampshire'),
(26, 414, 'US/NJ', 'New Jersey'),
(26, 415, 'US/NM', 'New Mexico'),
(26, 416, 'US/NV', 'Nevada'),
(26, 417, 'US/NY', 'New York'),
(26, 418, 'US/MP', 'Northern Mariana Islands'),
(26, 419, 'US/OH', 'Ohio'),
(26, 420, 'US/OK', 'Oklahoma'),
(26, 421, 'US/OR', 'Oregon'),
(26, 422, 'US/PA', 'Pennsylvania');

CREATE TABLE `xpweather_region` (
  `reg_id` int(11) NOT NULL default '0',
  `sign` varchar(10) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`reg_id`)
) TYPE=MyISAM;

INSERT INTO `xpweather_region` VALUES (1, 'AFR', 'Africa'),
(2, 'ANT', 'Antarctica'),
(3, 'ASIA', 'Asia'),
(4, 'AUS', 'Australia'),
(5, 'CAF', 'Central Africa'),
(6, 'CAM', 'Central America'),
(7, 'CAR', 'Caribbean'),
(8, 'CAS', 'Central Asia'),
(9, 'EEUR', 'Eastern Europe'),
(10, 'EUR', 'Europe'),
(11, 'IOI', 'Indian Ocean Islands'),
(12, 'ME', 'Middle East'),
(13, 'NAF', 'North Africa'),
(14, 'NAI', 'North Atlantic Islands'),
(15, 'NAM', 'North America'),
(16, 'NEZ', 'New Zealand'),
(18, 'SAF', 'South Africa'),
(19, 'SAI', 'South Atlantic Islands'),
(20, 'SAMER', 'South America'),
(21, 'SCAN', 'Scandinavia'),
(22, 'SEA', 'Southeast Asia'),
(23, 'SEUR', 'Southern Europe'),
(24, 'SPI', 'South Pacific Islands'),
(25, 'WEUR', 'Western Europe'),
(26, 'USA', 'United States');

CREATE TABLE `xpweather_station` (
  `reg_id` int(11) NOT NULL default '0',
  `ctry_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL default '0',
  `loc` varchar(10) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `reg_id` (`reg_id`),
  KEY `ctry_id` (`ctry_id`)
) TYPE=MyISAM;

