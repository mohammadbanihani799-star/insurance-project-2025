<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminLoginFailed extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     *
     * @param  array  $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ محاولة دخول إداري فاشلة')
            ->greeting('تنبيه أمني!')
            ->line('تم رصد محاولة فاشلة لتسجيل الدخول إلى لوحة التحكم.')
            ->line('**تفاصيل المحاولة:**')
            ->line('📧 البريد المستخدم: ' . ($this->event['email'] ?? 'غير متوفر'))
            ->line('🌐 عنوان IP: ' . $this->event['ip'])
            ->line('💻 المنصة: ' . $this->event['platform'])
            ->line('🔍 المتصفح: ' . $this->event['browser'])
            ->line('🔑 معرف الجهاز: ' . substr($this->event['device_id'], 0, 16) . '...')
            ->line('🕐 الوقت: ' . $this->event['time'])
            ->line('📝 السبب: ' . ($this->event['note'] ?? 'غير معروف'))
            ->line('**تحذير:** إذا تكررت المحاولات الفاشلة، يُنصح بفحص إعدادات الأمان.')
            ->action('عرض سجل الأمان', url('/'))
            ->line('كن آمناً!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'event' => 'admin_login_failed',
            'ip' => $this->event['ip'],
            'device_id' => $this->event['device_id'],
            'time' => $this->event['time'],
            'email' => $this->event['email'] ?? null
        ];
    }
}
