<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Fixed attitude scale (SQ options), order matters.
     */
    public const ATTITUDE_SCALE = ['Sangat setuju', 'Setuju', 'Tidak setuju', 'Sangat tidak setuju'];

    /**
     * Fixed behaviour scale (PQ options), order matters.
     */
    public const BEHAVIOUR_SCALE = ['Setiap hari', '4–6 hari', '1–3 hari', 'Tidak pernah'];

    /**
     * Knowledge questions: [indicator, question, options, correctIndex, explanation].
     */
    public const KNOWLEDGE = [
        ['Pengertian KEK', 'Rina hamil 5 bulan. Hasil ukur LILA-nya 22 cm. Artinya…', ['Rina tidak berisiko KEK', 'Rina berisiko KEK dan perlu segera ke bidan', 'Rina kelebihan berat badan'], 1, 'LILA di bawah 23,5 cm menandakan risiko KEK. Rina perlu segera diperiksa bidan dan mendapat makanan tambahan.'],
        ['Penyebab KEK', 'Kebiasaan mana yang dapat menyebabkan KEK?', ['Makan 3 kali sehari dengan lauk', 'Sering melewatkan makan dan jarang makan lauk hewani', 'Minum air putih 8 gelas sehari'], 1, 'Makan tidak teratur dan kurang protein dalam waktu lama membuat tubuh kekurangan energi dan protein.'],
        ['Faktor risiko KEK', 'Siapa yang paling berisiko mengalami KEK?', ['Ibu hamil usia 17 tahun yang sering tidak sarapan', 'Ibu hamil usia 25 tahun yang makan teratur', 'Ibu hamil usia 28 tahun yang rutin periksa'], 0, 'Usia di bawah 20 tahun dan pola makan tidak teratur adalah dua faktor risiko KEK.'],
        ['Dampak KEK pada ibu', 'Ibu hamil KEK sering lemas dan pucat karena berisiko mengalami…', ['Anemia (kurang darah)', 'Kelebihan gizi', 'Kencing manis'], 0, 'KEK sering disertai anemia, sehingga ibu mudah lelah, pucat, dan pusing.'],
        ['Dampak KEK pada bayi', 'Jika tidak ditangani, anak dari ibu KEK berisiko mengalami… saat tumbuh besar.', ['Stunting (tubuh lebih pendek dari seusianya)', 'Tumbuh lebih tinggi dari temannya', 'Lebih cepat tumbuh gigi'], 0, 'Bayi dari ibu KEK berisiko lahir dengan berat rendah dan mengalami stunting.'],
        ['Pencegahan: gizi seimbang', 'Isi piring yang dianjurkan setiap kali makan adalah…', ['Setengah piring nasi, sisanya kerupuk', 'Setengah piring sayur dan buah, setengah piring nasi dan lauk', 'Sepiring penuh nasi dengan sedikit lauk'], 1, 'Isi Piringku: setengah piring sayur dan buah, setengah piring makanan pokok dan lauk pauk.'],
        ['Pencegahan: TTD', 'Tablet tambah darah sebaiknya diminum bersama…', ['Teh manis', 'Kopi', 'Air putih atau jus jeruk'], 2, 'Teh, kopi, dan susu menghambat penyerapan zat besi. Air putih atau jus jeruk membantu.'],
        ['Pencegahan: ANC', 'Selama hamil, ibu sebaiknya memeriksakan kehamilan minimal…', ['2 kali', '4 kali', '6 kali'], 2, 'Minimal 6 kali: 2 kali di trimester 1, 1 kali di trimester 2, dan 3 kali di trimester 3.'],
        ['Pencegahan: ukur LILA', 'Pita LILA dilingkarkan di bagian…', ['Pergelangan tangan', 'Titik tengah antara bahu dan siku lengan kiri', 'Betis'], 1, 'Pita LILA dilingkarkan di titik tengah antara bahu dan siku, biasanya lengan kiri.'],
        ['Pencegahan: PMT', 'Jika LILA ibu di bawah 23,5 cm, bantuan gizi yang dapat diperoleh dari puskesmas adalah…', ['Makanan tambahan (PMT)', 'Vitamin rambut', 'Obat pelangsing'], 0, 'Ibu hamil KEK berhak mendapat PMT berbahan pangan lokal dari puskesmas.'],
        ['Suplementasi gizi', 'Tablet tambah darah (TTD) untuk ibu hamil berisi…', ['Zat besi dan asam folat', 'Vitamin C saja', 'Kalsium dan gula'], 0, 'TTD berisi zat besi dan asam folat untuk mencegah anemia dan mendukung pembentukan saraf janin.'],
        ['Sumber gizi utama', 'Kelompok makanan yang kaya zat besi adalah…', ['Teh dan kopi', 'Hati ayam, ikan, dan daun kelor', 'Kerupuk dan permen'], 1, 'Hati ayam, ikan, daging, dan sayuran hijau seperti daun kelor kaya zat besi.'],
        ['Isi Piringku ibu hamil KEK', 'Anjuran makan yang tepat bagi ibu hamil KEK adalah…', ['Makan sekali sehari dengan porsi besar', 'Mengurangi lauk agar tidak mual', 'Makan sedikit tapi sering, tambah lauk hewani, dan habiskan PMT'], 2, 'Ibu hamil KEK dianjurkan makan lebih sering dengan tambahan lauk hewani dan PMT sebagai selingan.'],
    ];

    /**
     * Attitude statements: [aspect, statement, favorable, goodFeedback, badFeedback].
     */
    public const ATTITUDE = [
        ['Kognitif', 'Mengukur LILA secara rutin penting agar risiko KEK cepat diketahui.', true, 'Tepat. Dengan mengukur LILA, risiko KEK bisa ditangani lebih awal.', 'KEK sering tidak terlihat dari luar. Mengukur LILA membantu Ibu mengetahuinya lebih awal.'],
        ['Kognitif', 'Selama badan tidak terlihat kurus, ibu hamil tidak perlu khawatir terkena KEK.', false, 'Tepat. KEK bisa terjadi walau badan tidak terlihat kurus.', 'KEK bisa terjadi walau badan tidak terlihat kurus. Cara memastikannya adalah mengukur LILA.'],
        ['Afektif', 'Saya merasa senang ketika berhasil makan lauk ikan atau telur hari ini.', true, 'Bagus! Rasa senang ini membantu Ibu menjadikan lauk hewani sebagai kebiasaan.', 'Tidak apa-apa. Coba mulai dari satu lauk hewani yang Ibu sukai, misalnya telur atau ikan bakar.'],
        ['Afektif', 'Saya merasa malu memeriksakan kehamilan karena usia saya masih muda.', false, 'Hebat. Memeriksakan kehamilan adalah tanda Ibu peduli pada diri dan bayi.', 'Perasaan itu wajar. Bidan siap membantu tanpa menghakimi, dan pemeriksaan penting untuk Ibu dan bayi.'],
        ['Konatif', 'Saya mau bertanya kepada bidan jika ragu tentang makanan yang boleh dimakan saat hamil.', true, 'Tepat. Bertanya ke bidan lebih aman daripada mengikuti kata orang.', 'Bidan adalah sumber informasi yang paling tepat. Simpan nomornya di menu Layanan supaya mudah dihubungi.'],
        ['Konatif', 'Saya akan berhenti minum TTD jika merasa mual, tanpa bertanya ke bidan.', false, 'Tepat. Jika mual, tanyakan ke bidan. TTD bisa diminum malam sebelum tidur.', 'Jangan berhenti sendiri. Tanyakan ke bidan; TTD bisa diminum malam sebelum tidur agar mual berkurang.'],
    ];

    /**
     * Behaviour questions: [indicator, question, tip].
     */
    public const BEHAVIOUR = [
        ['Tindakan: gizi seimbang', 'sarapan sebelum beraktivitas?', 'Sarapan memberi tenaga untuk Ibu dan janin. Coba siapkan nasi dan telur sejak malam.'],
        ['Tindakan: gizi seimbang', 'makan lauk hewani (ikan, telur, ayam, atau daging)?', 'Usahakan ada lauk hewani setiap hari. Ikan dan telur mudah didapat dan terjangkau.'],
        ['Tindakan: gizi seimbang', 'makan sayur dan buah?', 'Isi setengah piring dengan sayur dan buah, misalnya sayur kelor dan pisang.'],
        ['Tindakan: gizi seimbang', 'makan selingan sehat di antara makan utama?', 'Selingan seperti bubur kacang hijau atau buah membantu memenuhi tambahan porsi.'],
        ['Tindakan: kepatuhan anjuran', 'minum tablet tambah darah (TTD)?', 'TTD perlu diminum 1 tablet setiap hari. Pasang pengingat di ponsel agar tidak lupa.'],
        ['Tindakan: kepatuhan anjuran', 'tetap makan makanan bergizi (ikan, telur, sayur) tanpa berpantang karena mitos?', 'Ikan, telur, dan sayur aman dan penting untuk Ibu hamil. Lihat menu Info Menarik untuk fakta selengkapnya.'],
    ];

    public function run(): void
    {
        foreach (self::KNOWLEDGE as $position => [$indicator, $text, $options, $correct, $explanation]) {
            $question = QuizQuestion::create([
                'type' => 'pengetahuan',
                'indicator' => $indicator,
                'text' => $text,
                'position' => $position,
                'explanation' => $explanation,
            ]);

            foreach ($options as $i => $label) {
                $question->options()->create([
                    'label' => $label,
                    'position' => $i,
                    'is_correct' => $i === $correct,
                ]);
            }
        }

        foreach (self::ATTITUDE as $position => [$aspect, $text, $favorable, $good, $bad]) {
            $question = QuizQuestion::create([
                'type' => 'sikap',
                'aspect' => $aspect,
                'text' => $text,
                'position' => $position,
                'is_favorable' => $favorable,
                'good_feedback' => $good,
                'bad_feedback' => $bad,
            ]);

            foreach (self::ATTITUDE_SCALE as $i => $label) {
                $question->options()->create(['label' => $label, 'position' => $i]);
            }
        }

        foreach (self::BEHAVIOUR as $position => [$indicator, $text, $tip]) {
            $question = QuizQuestion::create([
                'type' => 'tindakan',
                'indicator' => $indicator,
                'text' => $text,
                'position' => $position,
                'tip' => $tip,
            ]);

            foreach (self::BEHAVIOUR_SCALE as $i => $label) {
                $question->options()->create(['label' => $label, 'position' => $i]);
            }
        }
    }
}
