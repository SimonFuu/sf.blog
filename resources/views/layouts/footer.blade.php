<footer class="text-center">
    <p></p>&copy; {{ date('Y') }} <a href="{{ route('index') }}">Simon Fu</a> | <a href="http://www.miibeian.gov.cn/" target="_blank">{{ Cache::get('SETTINGS')['ICP_NUMBER'] }}</a>
    <p>
        <span>CDN服务提供商</span>
        <a href="https://console.upyun.com/register/?invite=SJF8aPz6-" target="_blank"><img src="{{ config('app.storage_host') }}/storage/images/common/upyun.png" alt="" height="40"></a>
    </p>
</footer>