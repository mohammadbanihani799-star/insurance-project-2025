<footer class="bcare-footer">
    <div class="responsive-container">
        <div class="footer-top">
            <div class="footer-row">
                <div class="footer-col footer-logo-section">
                    <img src="{{ asset('style_files/frontend/img/Bcare-logo (White).svg') }}" alt="بي كير للتأمين" class="footer-logo">
                    <p class="footer-tagline">حلول التأمين الذكية لراحة بالك</p>
                </div>
                <div class="footer-col footer-license-section">
                    <div class="license-badge">
                        <span class="license-text">مصرح به من قبل</span>
                        <img src="{{ asset('style_files/frontend/img/haia.jpeg') }}" alt="هيئة التأمين" class="license-logo">
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="footer-middle">
            <div class="footer-links-grid">
                <div class="footer-links-column">
                    <h4 class="footer-column-title">عن بي كير</h4>
                    <ul class="footer-links-list">
                        <li><a href="#" class="footer-link">من نحن</a></li>
                        <li><a href="#" class="footer-link">رؤيتنا ورسالتنا</a></li>
                        <li><a href="#" class="footer-link">فريق العمل</a></li>
                        <li><a href="#" class="footer-link">التوظيف</a></li>
                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4 class="footer-column-title">خدماتنا</h4>
                    <ul class="footer-links-list">
                        <li><a href="#" class="footer-link">تأمين السيارات</a></li>
                        <li><a href="#" class="footer-link">التأمين الصحي</a></li>
                        <li><a href="#" class="footer-link">تأمين السفر</a></li>
                        <li><a href="#" class="footer-link">اطبع وثيقتك</a></li>
                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4 class="footer-column-title">الدعم والمساعدة</h4>
                    <ul class="footer-links-list">
                        <li><a href="#" class="footer-link">مركز المساعدة</a></li>
                        <li><a href="#" class="footer-link">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="footer-link">راسلنا</a></li>
                        <li><a href="#" class="footer-link">رفع شكوى</a></li>
                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4 class="footer-column-title">الشروط والسياسات</h4>
                    <ul class="footer-links-list">
                        <li><a href="#" class="footer-link">الشروط والأحكام</a></li>
                        <li><a href="#" class="footer-link">سياسة الخصوصية</a></li>
                        <li><a href="#" class="footer-link">سياسة الإلغاء</a></li>
                        <li><a href="#" class="footer-link">قواعد هيئة التأمين</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-social">
                    <h5 class="social-title">تابعنا على</h5>
                    <ul class="social-links">
                        <li>
                            <a href="#" target="_blank" class="social-link" aria-label="فيسبوك">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank" class="social-link" aria-label="تويتر">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank" class="social-link" aria-label="إنستجرام">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank" class="social-link" aria-label="لينكد إن">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank" class="social-link" aria-label="يوتيوب">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                   {{--Eng. B O N 7 1--}}
                <div class="footer-copyright">
                    <p>© {{ date('Y') }} بي كير للتأمين. جميع الحقوق محفوظة.</p>
                </div>

                <div class="footer-complaint">
                    <a href="#" class="complaint-link">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>رفع شكوى لهيئة التأمين</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=GE+Dinar+One:wght@300;400;500;700&display=swap');

.bcare-footer {
    background: linear-gradient(135deg, #1a4060 0%, #275C86 100%);
    color: #ffffff;
    padding: 3rem 0 1.5rem;
    margin-top: 4rem;
    font-family: 'GE Dinar One', 'Cairo', sans-serif;
}

.responsive-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ===== القسم العلوي ===== */
.footer-top {
    margin-bottom: 2rem;
}

.footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.footer-col {
    flex: 1;
    min-width: 250px;
}

.footer-logo-section {
    text-align: right;
}

.footer-logo {
    height: 32px;
    width: auto;
    max-width: 95px;
    margin-bottom: 1rem;
    filter: brightness(0) invert(1);
}

.footer-tagline {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 400;
    display: none; /* مخفي افتراضيًا في الشاشات الكبيرة */
}

.footer-license-section {
    text-align: left;
}

.license-badge {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.license-text {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.license-logo {
    height: 28px;
    width: auto;
    max-width: 60px;
}

/* ===== الخط الفاصل ===== */
.footer-divider {
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255, 255, 255, 0.3) 50%,
        transparent 100%
    );
    margin: 2rem 0;
}

/* ===== القسم الأوسط: الروابط ===== */
.footer-middle {
    margin-bottom: 2rem;
}

.footer-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

.footer-links-column {
    text-align: right;
}

.footer-column-title {
    color: #ffffff;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-column-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 40px;
    height: 2px;
    background: #00d4ff;
}

.footer-links-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links-list li {
    margin-bottom: 0.75rem;
}

.footer-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-block;
    position: relative;
}

.footer-link::before {
    content: '';
    position: absolute;
    bottom: -2px;
    right: 0;
    width: 0;
    height: 2px;
    background: #00d4ff;
    transition: width 0.3s ease;
}

.footer-link:hover {
    color: #00d4ff;
    transform: translateX(-5px);
}

.footer-link:hover::before {
    width: 100%;
}

.footer-bottom {
    padding-top: 1.5rem;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.footer-social {
    text-align: right;
}

.social-title {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.social-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 0.75rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #ffffff;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: #00d4ff;
    color: #1a4060;
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0, 212, 255, 0.4);
}

.footer-copyright {
    text-align: center;
    flex: 1;
}

.footer-copyright p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin: 0;
}

.footer-complaint {
    text-align: left;
}

.complaint-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.6rem 1.2rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.complaint-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #00d4ff;
    transform: translateY(-2px);
}

.complaint-link i {
    font-size: 1.1rem;
}


@media (max-width: 768px) {
    .bcare-footer {
        padding: 2.5rem 0 1.5rem;
        margin-top: 3rem;
    }

    .footer-row {
        flex-direction: column;
        text-align: center;
    }

    .footer-logo-section,
    .footer-license-section {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .footer-logo-section {
        margin: 0 auto;
    }

    .footer-column-title::after {
        right: 50%;
        transform: translateX(50%);
    }

    .footer-links-column {
        text-align: center;
    }

    .footer-links-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1.5rem;
    }

    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }

    .footer-social,
    .footer-complaint {
        text-align: center;
    }

    .social-links {
        justify-content: center;
    }
}

/* Tablet to Mobile (481px - 768px) - تحسين التدرج */
@media (max-width: 768px) and (min-width: 481px) {
    .footer-logo {
        height: 20px;
        max-width: 60px;
    }

    .license-logo {
        height: 18px;
        max-width: 45px;
    }
}

/*--Eng. B O N 7 1--*/
@media (max-width: 480px) {
    .bcare-footer {
        padding: 2rem 0 1rem;
        margin-top: 2rem;
    }

    .responsive-container {
        padding: 0 1rem;
    }

    .footer-logo {
        height: 14px;
        max-width: 45px;
        margin: 0 auto;
        display: block;
    }

    .footer-tagline {
        display: block;
        text-align: center;
        margin-top: 0.75rem;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .license-logo {
        height: 12px;
        max-width: 32px;
    }
}

/* Extra Small Mobile (380px and below) */
@media (max-width: 380px) {
    .footer-logo {
        height: 12px;
        max-width: 40px;
    }

    .footer-tagline {
        font-size: 0.8rem;
    }

    .license-badge {
        padding: 0.75rem 1rem;
        gap: 0.75rem;
    }

    .license-logo {
        height: 10px;
        max-width: 28px;
    }

    .license-text {
        font-size: 0.8rem;
    }

    .license-badge {
        padding: 0.75rem 1rem;
        gap: 0.75rem;
        flex-direction: column;
    }

    .license-logo {
        height: 35px;
    }

    .footer-links-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .footer-column-title {
        font-size: 1rem;
    }

    .footer-link {
        font-size: 0.9rem;
    }

    .social-link {
        width: 36px;
        height: 36px;
    }

    .complaint-link {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bcare-footer {
    animation: fadeInUp 0.8s ease;
}
</style>
