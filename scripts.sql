-- sitemap.xml
SELECT CONCAT('<url><loc>http://xt.ua/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '.html</loc></url>') AS url FROM xt_product WHERE indexation = 1
UNION
SELECT CONCAT('<url><loc>http://xt.ua/news/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc><priority>0.9</priority></url>') AS url FROM xt_news WHERE indexation = 1 AND sid = 1
UNION
SELECT CONCAT('<url><loc>http://xt.ua/page/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc><priority>0.8</priority></url>') AS url FROM xt_page WHERE indexation = 1 AND xt = 1;