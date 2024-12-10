<style>
    /* Loading Page Styles */
    #loading-page {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        background-color: #ffffff;
    }

    /* Loader Animation */
    .loader {
        width: 50px;
        aspect-ratio: 1;
        --_g: no-repeat radial-gradient(farthest-side, #007bff 94%, #007bff00);
        background:
            var(--_g) 0 0,
            var(--_g) 100% 0,
            var(--_g) 100% 100%,
            var(--_g) 0 100%;
        background-size: 40% 40%;
        animation: l38 .5s infinite;
    }

    @keyframes l38 {
        100% {
            background-position: 100% 0, 100% 100%, 0 100%, 0 0;
        }
    }

    /* Hide page content initially */
    .page {
        display: none;
        /* Hidden at first */
    }
</style>

<!-- Loading Page -->
<div id="loading-page">
    <div class="loader"></div>
</div>

<script>
    // Simulate loading process
    window.onload = function() {
        setTimeout(() => {
            // Hide loading screen
            document.getElementById('loading-page').style.display = 'none';
            // Show page content with fade-in effect
            const pageContent = document.querySelector('.page');
            pageContent.style.display = 'block';
            pageContent.classList.add('animate__fadeIn');
        }, 500);
    };
</script>