<p>График (своя версия)</p>
<div class="select_go" style="margin-top: 15px;margin-left: 77px;">

  <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">

  <span class="mdl-switch__label" style="float: left;margin-left: -130px;">Розница</span>

  <input type="checkbox" id="switch-2" class="mdl-switch__input">
  <span class="mdl-switch__label">Опт</span>
</label>
</div>
  <?if(!empty($values)){
    foreach($values as $key => $value){
      // var_dump(strpos($key, 'value_'));
      if(strpos($key, 'value_') !== false){?>
        <div class="slider_wrap">
          <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$value?>" step="1" tabindex="0">
        </div>
      <?}
    }
  }else{?>
  <div class="mdl-color--grey-100 mdl-cell--hide-phone clearfix toggle one">
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_1']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_2']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_3']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_4']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_5']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_6']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_7']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_8']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_9']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_10']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_11']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['roz']['value_12']?>" step="1" tabindex="0">
    </div>
  </div>

  <div class="mdl-color--grey-100 mdl-cell--hide-phone clearfix toggle two hidden">
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_1']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_2']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_3']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_4']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_5']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_6']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_7']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_8']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_9']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_10']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_11']?>" step="1" tabindex="0">
    </div>
    <div class="slider_wrap">
      <input class="mdl-slider mdl-js-slider" type="range" min="0" max="10" value="<?=$val['opt']['value_12']?>" step="1" tabindex="0">
    </div>
  </div>
  <?}?>
<div class="mdl-textfield">
  <label for="name" class="mdl-textfield__textarea">Примечания к графику:</label>
  <textarea required="required" type="text" name="text" id="text" style="width:80%;">
  </textarea>
</div>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="top: -10px;">
  <label for="name" class="mdl-textfield__label">Имя на графике:</label>
  <input class="mdl-textfield__input" type="text" id="name_user" value=""/>
</div>
<div id="user_bt" style="float:right;padding-right: 15px;margin-top: 40px;">
  <a href="#" class="save btn_js mdl-button" onclick="ModalGraph()">Сохранить</a>
</div>
<script>
  $('.select_go label').on('change', function() {
    $('.mdl-color--grey-100.toggle').toggleClass('hidden');
    /*console.log('trues');
    if($(this).is(':checked')){
       console.log('trues');
      $('.mdl-color--grey-100').eq(0).not(':has(div.hidden)').addClass('hidden');
      $('.mdl-color--grey-100').eq(1).hasClass('hidden').removeClass('hidden');
    }else{
      $('.mdl-color--grey-100').eq(1).not(':has(div.hidden)').addClass('hidden');
      $('.mdl-color--grey-100').eq(0).hasClass('hidden').removeClass('hidden');}*/
  });
</script>