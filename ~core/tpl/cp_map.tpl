<script language="JavaScript" src="http://api-maps.yandex.ru/1.1/index.xml?key=AC3vdkoBAAAAJvT-cQMArGHlb3MsCJbclC1-YajwyxyrUDoAAAAAAAAAAABdxRz76FwVU7GYs1Nf3epypelyWQ==" type="text/javascript"></script>

    <script type="text/javascript" language="JavaScript">

        window.onload = function () {

            var map = new YMaps.Map(document.getElementById("YMapsID"));

            map.setCenter(new YMaps.GeoPoint(36.276325,49.995625), 12);

            map.addControl(new YMaps.TypeControl());

            map.addControl(new YMaps.Zoom());

			map.addControl(new YMaps.ScaleLine());

			map.addControl(new YMaps.ToolBar());

			map.enableScrollZoom();



            var bounds = map.getBounds(),

            pointLb  = bounds.getLeftBottom(),

            span = bounds.getSpan();



			var gCollection = new YMaps.GeoObjectCollection();

			gCollectionBounds = new YMaps.GeoCollectionBounds();



<?foreach ($data as $row){?>

	<?if (($row['x'] != 0) && ($row['y'] != 0)) {?>

		var x="<?=$row['x'];?>";

		var y="<?=$row['y'];?>";

		var id="<?=$row['id'];?>";

		var adress="<?=$row['address'];?>";

		var img="<?php echo ($row['photo'] ? $row['photo'] : 'nophoto_sxema.jpg');?>";

        var point = new YMaps.GeoPoint(x,y);

        var placemark = new YMaps.Placemark(point);

        placemark.setBalloonContent("<rh2><?=$row['address']?></rh2><br><center>&nbsp;&nbsp;&nbsp;<img width=\"350px;\" src=\"<?=_base_url?>/images/adrnar/"+img +"\"></center><br><a target=_blank href=\"<?=_base_url?>/adrnaritem/<?=$row['id']?> \">Подробнее</a>");

        map.addOverlay(placemark);

	<?}?>

<?}?>

              YMaps.Events.observe(map, map.Events.Click, function (map, mEvent) {

                 var myHtml = "Значение: " + mEvent.getGeoPoint() + " на масштабе " + map.getZoom();

                map.openBalloon(mEvent.getGeoPoint(), myHtml);

           });

        };

    </script>

<br><br>

	<div id="YMapsID" style="width:1000px;height:760px;margin-left:-200px"></div>

