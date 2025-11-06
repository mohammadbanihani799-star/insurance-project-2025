<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminLoginSuccess extends Notification
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
            ->subject('✅ تسجيل دخول إداري ناجح')
            ->greeting('مرحباً!')
            ->line('تم تسجيل دخول إداري ناجح إلى لوحة التحكم.')
            ->line('**تفاصيل الدخول:**')
            ->line('👤 المستخدم: ' . ($this->event['admin_name'] ?? 'غير معروف'))
            ->line('🌐 عنوان IP: ' . $this->event['ip'])
            ->line('💻 المنصة: ' . $this->event['platform'])
            ->line('🔍 المتصفح: ' . $this->event['browser'])
            ->line('🔑 معرف الجهاز: ' . substr($this->event['device_id'], 0, 16) . '...')
            ->line('🕐 الوقت: ' . $this->event['time'])
            ->line('إذا لم تكن أنت من قام بهذا الإجراء، يرجى اتخاذ الإجراءات الأمنية اللازمة فوراً.')
            ->action('عرض لوحة التحكم', url('/'))
            ->line('شكراً لك!');
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
            'event' => 'admin_login_success',
            'ip' => $this->event['ip'],
            'device_id' => $this->event['device_id'],
            'time' => $this->event['time']
        ];
    }
}
