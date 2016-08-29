-- sitemap.xml
SELECT CONCAT('<url><loc>http://xt.ua/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '.html</loc></url>') AS url FROM xt_product WHERE indexation = 1
UNION
SELECT CONCAT('<url><loc>http://xt.ua/news/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc><priority>0.9</priority></url>') AS url FROM xt_news WHERE indexation = 1 AND sid = 1
UNION
SELECT CONCAT('<url><loc>http://xt.ua/page/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc><priority>0.8</priority></url>') AS url FROM xt_page WHERE indexation = 1 AND xt = 1;

-- uncategorised products
SELECT p.id_product, p.art, p.name, p.translit, CONCAT('http://xt.ua/adm/productedit/', p.id_product) AS editlink
FROM xt_product AS p
where (p.price_mopt > 0 OR p.price_opt > 0)
AND p.visible = 1
AND p.id_product IN (SELECT a.id_product FROM xt_assortiment AS a WHERE a.active = 1)
AND p.id_product not in (
	select cp.id_product
    from xt_cat_prod as cp
    LEFT JOIN xt_category AS c
		ON c.id_category = cp.id_category
	WHERE c.sid = 1);


-- active assortment with disabled suppliers
SELECT *
FROM xt_assortiment AS a
LEFT JOIN xt_user AS u ON u.id_user = a.id_supplier
WHERE a.active = 1
AND u.active = 0;

-- disable active assortment with disabled suppliers
UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE (SELECT active FROM xt_user WHERE id_user = id_supplier) = 0;
