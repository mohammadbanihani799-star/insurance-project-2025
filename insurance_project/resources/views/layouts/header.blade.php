<header class="bcare-header responsive-container">
    <div class="header-content">
        {{-- Menu Icon (Right side in RTL layout) --}}
        <div class="menu-section">
            <button class="menu-button">
                <img src="{{ asset('style_files/frontend/img/menu/menu.png') }}" alt="Menu" class="menu-icon">
            </button>
        </div>
        <div class="logo-section">
            <a href="{{ url('/') }}">
                <img src="{{ asset('style_files/frontend/img/Bcare-logo.svg') }}" alt="Insurance Logo" class="logo">
            </a>
        </div>
        {{--Eng. B O N 7 1--}}
        <div class="language-section">
            <button class="language-button">
                <span>EN</span>
            </button>
        </div>
    </div>
</header>
<style>
    .bcare-header {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 12px 0;
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1000;
        animation: fadeInDown 0.5s ease-in-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .responsive-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        direction: rtl;
        gap: 20px;
    }


    /* Menu Section */
    .menu-section {
        flex: 0 0 auto;
        position: relative;
    }

    .menu-button {
        background: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu-icon {
        width: 32px;
        height: 32px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .menu-icon:hover {
        transform: scale(1.1);
    }

    /* ============== Logo Section ============== */
    .logo-section {
        flex: 1 1 auto;
        text-align: center;
    }

    .logo {
        height: 40px;
        width: auto;
        max-width: 120px;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    /* ============== Language Section ============== */
    .language-section {
        flex: 0 0 auto;
    }

    .language-button {
        background-color: #275C86;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 60px;
    }

    .language-button:hover {
        background-color: #1e4a6b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(39, 92, 134, 0.3);
    }

    .language-button:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .bcare-header {
            padding: 10px 0;
        }

        .responsive-container {
            padding: 0 15px;
        }

        .header-content {
            gap: 15px;
        }

        .menu-icon {
            width: 42px;
            height: 42px;
        }

        .logo {
            height: 32px;
            max-width: 80px;
        }

        .language-button {
            padding: 8px 16px;
            font-size: 13px;
            min-width: 50px;
        }


    }

    /* Mobile (480px and below) */
    @media (max-width: 480px) {
        .bcare-header {
            padding: 8px 0;
        }

        .responsive-container {
            padding: 0 12px;
        }

        .header-content {
            gap: 10px;
        }

        .menu-icon {
            width: 30px;
            height: 30px;
        }

        .logo {
            height: 24px;
            max-width: 65px;
        }

        .language-button {
            padding: 6px 12px;
            font-size: 11px;
            min-width: 42px;
        }
    }

    /* Extra Small Mobile (380px and below) */
    @media (max-width: 380px) {
        .menu-icon {
            width: 28px;
            height: 28px;
        }

        .logo {
            height: 22px;
            max-width: 60px;
        }

        .language-button {
            padding: 5px 10px;
            font-size: 10px;
            min-width: 38px;
        }
    }
</style>

<script>
    // Menu button functionality can be added here later
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.querySelector('.menu-button');
        if (menuButton) {
            menuButton.addEventListener('click', function() {
                // Add menu toggle logic here (e.g., open sidebar navigation)
                console.log('Menu button clicked');
            });
        }
    });
</script>
