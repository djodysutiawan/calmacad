// public/firebase-messaging-sw.js
//
// Service Worker untuk Firebase Cloud Messaging (Web Push).
// File ini WAJIB berada di root folder public/ (bukan di resources/js/)
// supaya bisa diakses langsung di /firebase-messaging-sw.js dan punya
// scope yang mencakup seluruh halaman situs.

importScripts(
    "https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js",
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js",
);

// Konfigurasi Firebase — isi sesuai project Firebase Console kamu.
// Catatan: nilai-nilai ini AMAN ditaruh di file publik karena memang
// untuk identifikasi client-side, bukan secret key.
firebase.initializeApp({
    apiKey: "GANTI_DENGAN_API_KEY",
    authDomain: "calmacad-xxx.firebaseapp.com",
    projectId: "calmacad-xxx",
    messagingSenderId: "GANTI_DENGAN_SENDER_ID",
    appId: "GANTI_DENGAN_APP_ID",
});

const messaging = firebase.messaging();

/**
 * Dipanggil saat ada push notification masuk SEMENTARA
 * browser/tab CalmAcad sedang di background atau tertutup.
 */
messaging.onBackgroundMessage((payload) => {
    const title = payload.notification?.title || "CalmAcad";
    const body = payload.notification?.body || "";
    const data = payload.data || {};

    const notificationOptions = {
        body,
        icon: "/images/calmacad-icon.png",
        badge: "/images/badge.png",
        data,
        actions: [{ action: "open", title: "Buka Sekarang" }],
    };

    self.registration.showNotification(title, notificationOptions);
});

/**
 * Tangani klik pada notifikasi: arahkan user ke halaman yang relevan
 * (misal dashboard konsultasi), atau fokuskan tab yang sudah terbuka.
 */
self.addEventListener("notificationclick", (event) => {
    event.notification.close();

    const targetUrl = event.notification.data?.click_action || "/dashboard";

    event.waitUntil(
        clients
            .matchAll({ type: "window", includeUncontrolled: true })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url.includes(targetUrl) && "focus" in client) {
                        return client.focus();
                    }
                }
                if (clients.openWindow) {
                    return clients.openWindow(targetUrl);
                }
            }),
    );
});
