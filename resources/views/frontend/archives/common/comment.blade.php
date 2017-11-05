<!--PC和WAP自适应版-->
<script>
    var CHANGYAN_APP_ID = '{{ Cache::get('SETTINGS')['SITE_CHANGYAN_APP_ID'] }}';
    var CHANGYAN_CONF = '{{ Cache::get('SETTINGS')['SITE_CHANGYAN_CONF'] }}';
</script>
<div id="SOHUCS" class="comments" sid="{{ $archiveUri }}" ></div>
