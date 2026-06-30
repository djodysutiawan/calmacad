<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $table_name
 * @property int|null $record_id
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $konsultasi_id
 * @property int $gejala_id
 * @property numeric $cf_user
 * @property numeric $cf_hasil
 * @property-read \App\Models\Gejala $gejala
 * @property-read \App\Models\Konsultasi $konsultasi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi whereCfHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi whereCfUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi whereGejalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKonsultasi whereKonsultasiId($value)
 */
	class DetailKonsultasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode
 * @property string $nama_gejala
 * @property string $kategori
 * @property numeric $cf_pakar
 * @property string|null $deskripsi
 * @property bool $is_active
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailKonsultasi> $detailKonsultasi
 * @property-read int|null $detail_konsultasi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala kategori(string $kategori)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereCfPakar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereNamaGejala($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereUrutan($value)
 */
	class Gejala extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $guest_token
 * @property string $nama_responden
 * @property string $jenis_kelamin
 * @property string|null $status_akademik
 * @property numeric $cf_combine
 * @property numeric $cf_persen
 * @property int $tingkat_stres_id
 * @property bool $is_kritis
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailKonsultasi> $detailKonsultasi
 * @property-read int|null $detail_konsultasi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\TingkatStres $tingkatStres
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi guest()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi kritis()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi terdaftar()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereCfCombine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereCfPersen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereGuestToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereIsKritis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereNamaResponden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereStatusAkademik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereTingkatStresId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Konsultasi whereUserId($value)
 */
	class Konsultasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $konsultasi_id
 * @property string $type
 * @property string $title
 * @property string $body
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Konsultasi|null $konsultasi
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationLog> $logs
 * @property-read int|null $logs_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification dueNow()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereKonsultasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $notification_id
 * @property array<array-key, mixed>|null $fcm_response
 * @property string $status
 * @property \Illuminate\Support\Carbon $sent_at
 * @property-read \App\Models\Notification $notification
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereFcmResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereStatus($value)
 */
	class NotificationLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tingkat_stres_id
 * @property string $judul_lagu
 * @property string $artis
 * @property string|null $keterangan_terapeutik
 * @property string|null $spotify_url
 * @property string|null $youtube_url
 * @property string|null $cover_url
 * @property int $urutan
 * @property-read \App\Models\TingkatStres $tingkatStres
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereArtis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereJudulLagu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereKeteranganTerapeutik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereSpotifyUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereTingkatStresId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereUrutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Playlist whereYoutubeUrl($value)
 */
	class Playlist extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tingkat_stres_id
 * @property string $kategori
 * @property string $judul
 * @property string $konten
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TingkatStres $tingkatStres
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi kategori(string $kategori)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereKonten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereTingkatStresId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rekomendasi whereUrutan($value)
 */
	class Rekomendasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $definisi
 * @property string|null $ciri_khas
 * @property numeric $min_cf
 * @property numeric $max_cf
 * @property int $min_gejala
 * @property int|null $max_gejala
 * @property string $warna_hex
 * @property string|null $icon
 * @property int $urutan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Konsultasi> $konsultasi
 * @property-read int|null $konsultasi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Playlist> $playlist
 * @property-read int|null $playlist_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rekomendasi> $rekomendasi
 * @property-read int|null $rekomendasi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereCiriKhas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereDefinisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereMaxCf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereMaxGejala($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereMinCf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereMinGejala($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereUrutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TingkatStres whereWarnaHex($value)
 */
	class TingkatStres extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $photo
 * @property string|null $fcm_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuditLog> $auditLogs
 * @property-read int|null $audit_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Konsultasi> $konsultasi
 * @property-read int|null $konsultasi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

