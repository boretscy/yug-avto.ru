<!-- Lazy Third-Party Scripts Optimization for Mobile -->
<script data-skip-moving="true">
(function() {
    var loaded = false;
    function loadThirdPartyScripts() {
        if (loaded) return;
        loaded = true;

        // 1. Yandex.Metrika
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(6251896, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true });

        // 2. Calltouch
        (function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)},m=typeof Array.prototype.find === 'function',n=m?"init-min.js":"init.js";s.type="text/javascript";s.async=true;s.src="https://mod.calltouch.ru/"+n+"?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","78d47ede");

        // 3. Go API Widgets
        var t = 'ef6541490c8bb9d481d37020b6a1953e',
            r = location.href, 
            s = document.createElement('script');
        s.type = 'text/javascript';
        s.charset = 'utf-8';
        s.src = 'https://<?= YApp::GO_API_DOMAIN ?>/API/get/widgets3-script/'+'?token='+t+'&r='+r;
        document.body.append(s);

        // 4. Talk-Me
        (function(){(function c(d,w,m,i) {
            window.supportAPIMethod = m;
            var s = d.createElement('script');
            s.id = 'supportScript'; 
            var id = '1195b982f1aff86949235a3e32305b5f';
            s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
            s.onerror = i ? undefined : function(){c(d,w,m,true)};
            w[m] = w[m] ? w[m] : function(){(w[m].q = w[m].q ? w[m].q : []).push(arguments);};
            (d.head ? d.head : d.body).appendChild(s);
        })(document,window,'TalkMe')})();
    }

    var events = ['pointerdown', 'touchstart', 'scroll', 'mousemove', 'keydown'];
    events.forEach(function(e) {
        window.addEventListener(e, loadThirdPartyScripts, {passive: true, once: true});
    });
    setTimeout(loadThirdPartyScripts, 3500);
})();
</script>