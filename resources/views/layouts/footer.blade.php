<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<footer class="py-3 text-bg-dark shadow-lg" style="position:absolute;width:100%;">
    <div class="mx-auto row">
        <div class="col-md-3">
            <h6><img src="{{asset('img/favicon.png')}}" style="width:10%">{{config('app.name')}}</h6>
            <p>Web-based E-commerce Application.<br>Powered by milk-tea.</p>
        </div>
        <div class="col-md-3">
            <h6 class="border-bottom">About Us</h6>
            <a href="{{route('who made this')}}" class="text-white">{{__('About this app')}}</a>
            <br>
            <a href="{{route('who made this')}}" class="text-white">{{__('Who made this ?')}}</a>
        </div>
        <div class="col-md-3">
            <h6 class="border-bottom">Useful Links</h6>
        </div>
        <div class="col-md-3">
            <h6 class="border-bottom">Contact</h6>
            <i class="bi bi-whatsapp me-2"></i><span>+62 858-2282-7064</span>
            <br>
            <a class="text-white" href="mailto:dheway.apriandi@gmail.com"><i class="bi bi-envelope me-2"></i>dheway.apriandi@gmail.com</a>
            <br>
            <a class="text-white" href="https://www.linkedin.com/in/devan-apriandi-dwicahya/" target="_blank"><i class="bi bi-linkedin me-2"></i>Devan Apriandi Dwicahya</a>
            <br>
            <a class="text-white" href="https://www.github.com/kacanggelap/" target="_blank"><i class="bi bi-github me-2"></i>KacangGelap</a>
        </div>
    </div>
    <hr>
    <div class="container text-center">
        <div class="copyright text-sm text-lg-center">
        © <script>
            document.write(new Date().getFullYear())
        </script>,
        made with ❤ by
        <a href="https://github.com/kacanggelap/" class="font-weight-bold text-light" target="_blank">Darkhazel</a>
        for a better Web Application.
        </div>
    <p id="current-time-placeholder" class="text-center text-sm  text-lg-center"></p>
  </div>
        
    </div>
    
</footer>
<script>
function updateCurrentTime() {
    var currentTimeElement = document.getElementById('current-time-placeholder');

    if (currentTimeElement) {
        function updateTime() {
            var now = new Date();
            var formattedTime = now.toLocaleTimeString('en-US', { hour12: false });
            currentTimeElement.textContent = "Current Time : " + formattedTime;
        }

        // Update the time immediately
        updateTime();

        // Update the time every seconds
        setInterval(updateTime, 500);
    }
}

document.addEventListener('DOMContentLoaded', updateCurrentTime);
</script>