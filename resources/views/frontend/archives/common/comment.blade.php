<!--PC和WAP自适应版-->
<script>
    var CHANGYAN_APP_ID = '{{ Cache::get(env('APP_NAME') . '_SETTINGS')['SITE_CHANGYAN_APP_ID'] }}';
    var CHANGYAN_CONF = '{{ Cache::get(env('APP_NAME') . '_SETTINGS')['SITE_CHANGYAN_CONF'] }}';
</script>
<div id="SOHUCS" class="comments" sid="{{ $archiveUri }}" ></div>
