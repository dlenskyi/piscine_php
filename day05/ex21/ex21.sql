SELECT md5(REPLACE(CONCAT(phone_number, '42'), '7', '9')) as ft5
FROM distrib
WHERE id_distrib = 84;