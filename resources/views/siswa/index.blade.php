@extends('layout_siswa.app')
@section('konten')
<style>
    body, h2, h1 {
        font-family: 'Times New Roman', Times, serif, sans-serif;
    }
    .ekskul-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }
    .ekskul-item {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .ekskul-item:hover {
        background-color: #f0f0f0;
    }
    #myBtn {
        display: none; /* Tombol "Go to top" disembunyikan awalnya */
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #555;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 4px;
    }
    #myBtn:hover {
        background-color: #333;
    }
</style>

<title>Dashboard</title>

<body>


<!-- Tombol Go to Top -->
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center text-primary">Home Page</h1>

            <hr>
            <h2 class="text-center">Ekstrakurikuler</h2>
            <div class="ekskul-list">
                <a href="#Bola Voly" class="ekskul-item">Bola Voly</a>
                <a href="#Pencak Silat" class="ekskul-item">Pencak Silat</a>
                <a href="#Sepak Bola" class="ekskul-item">Sepak Bola</a>
                <a href="#Komputer" class="ekskul-item">Komputer</a>
                <a href="#OSN Matematika" class="ekskul-item">OSN Matematika</a>
                <a href="#Seni Musik" class="ekskul-item">Seni Musik</a>
                <a href="#Bola Basket" class="ekskul-item">Bola Basket</a>
                <a href="#Sepak Takraw" class="ekskul-item">Sepak Takraw</a>
                <a href="#Story Telling" class="ekskul-item">Story Telling</a>
                <a href="#Seni Tari" class="ekskul-item">Seni Tari</a>
                <a href="#PMR" class="ekskul-item">PMR</a>
                <a href="#Mading" class="ekskul-item">Mading</a>
                <a href="#Tata Boga" class="ekskul-item">Tata Boga</a>
                <a href="#Pramuka" class="ekskul-item">Pramuka</a>
                <a href="#OSN IPA" class="ekskul-item">OSN IPA</a>
            </div>
                        <div>
                            <hr>
                            <h2 id="Bola Voly"> Bola Voly</h2>
                            <hr>
                            <img src="{{ asset('admin/img/Voly.jpg') }}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify"> &nbsp;&nbsp;&nbsp;Ekstrakurikuler Bola Voli merupakan bagian integral dari
                                mata pelajaran Pendidikan Jasmani Olahraga dan Kesehatan. Penyelenggaraan ekstrakurikuler
                                Bola Voli di SMP 2 Jekulo kudus bertujuan untuk mengembangkan aspek kebugaran jasmani,
                                keterampilan gerak, berpikir kritis, dan keterampilan sosial.Ekstrakurikuler Bola Voli
                                memiliki peran sangat penting, terutama memberikan kesempatan kepada siswa dalam
                                pengembangan diri dan meraih prestasi di bidang non akademik.
                            </p>

                            <ol>
                                <li>Tujuan Kegiatan</li>
                                <ul>
                                    <li>Menyiapkan atlet berprestasi di tingkat kabupaten.</li>
                                    <li>Meningkatkan prestasi siswa melalui ekstrakurikuler Bola Voli.</li>
                                    <li>Mengikuti pertandingan antar pelajar tingkat kabupaten.</li>
                                    <li>Sebagai wadah bagi siswa untuk mengasah bakat.</li>
                                    <li>Sarana pengembangan diri dan prestasi non akademik.</li>
                                </ul>

                                <li>Bentuk Kegiatan</li>
                                <ul>
                                    <li>Melakukan berbagai kegiatan teori dan praktik yang relevan.</li>
                                    <li>Membuat berbagai model latihan untuk peningkatan prestasi.</li>
                                    <li>Menyusun ragam kegiatan praktik dan latihan sesuai dengan kondisi siswa.</li>
                                </ul><br>
                            </ol>

                            <hr>
                            <h2 id="Pencak Silat" align="right">Pencak Silat</h2>
                            <hr>
                            <img src="{{ asset('admin/img/Pencak silat.png') }}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;Ekskurikuler beladiri pencak silat adalah wadah bagi siswa yang baru
                                ingin mengenal dan yang telah memiliki kemampuan dalam beladiri pencak silat. Sehingga
                                mereka bisa mengembangkan dan mengekspresikan diri mereka melalui beladiri pencak silat ini.
                                Ekskul beladiri pencak silat tentunya terbuka untuk semua siswa yang berkeinginan untuk
                                pandai beladiri tradisional. <br>Tujuan adanya ekskul pencak silat adalah:
                            <ul>
                                <li>Wadah para siswa untuk mengembangkan minat dan bakat dalam beladiri pencak silat</li>
                                <li>Mengarahkan siswa agar melakukan kegiatan yang lebih positif</li>
                                <li>Menyalurkan kemampuan dan meningkatkan prestasi</li>
                                <li>Serta melatih mentalitas dan kedisiplinan diri pada siswa</li>
                            </ul><br>
                            </p>
                            <hr>
                            <h2 id="Sepak Bola">Sepak Bola</h2>
                            <hr>
                            <img src="{{ asset('admin/img/sepak bola.jpg') }}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                Kegiatan ekstrakurikuler sepakbola merupakan kegiatan sekolah yang dilakukan di luar jam
                                pelajaran dengan tujuan untuk memperdalam dan memperluas pengetahuan, meningkatkan prestasi,
                                menyalurkan minat, dan bakat serta melengkapi upaya pembinaan manusia seutuhnya.
                            </p><br><br><br><br>

                            <hr>
                            <h2 id="Komputer" align="right">Komputer</h2>
                            <hr>
                            <img src="{{ asset('admin/img/komputer.png') }}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                Ekskul Komputer, adalah kegiatan life skill mengenalkan anak pada peralatan multimedia
                                seperti komputer, dan melatih siswa agar mampu mengoperasi alat-alat sederhana seperti
                                fungsi mouse, keyboard, layar monitor dan menyalakan CPU. Dan tidak itu saja, anak-anak juga
                                dikenalkan fungsi-fungsi tombol layar seperti save, quit, enter, klik 1 atau 2 kali pada
                                folder-folder file dan lain-lain.
                            </p><br><br><br><br><br> <br>

                            <hr>
                            <h2 id="OSN Matematika">OSN Matematika</h2>
                            <hr>
                            <img src="{{ asset('admin/img/OSN Matematika.png') }}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                OSN atau olimpiade sains nasional, merupakan sebuah kegiatan rutin pemerintah dalam
                                menyaring siswa-siswa yang berprestasi. OSN diadakan secara bertahap, mulai dari tingkat
                                kabupaten, provinsi, nasional dan ke tingkat internasional. Untuk menjuarai event tersebut,
                                maka setiap sekolah tentunya harus membimbing siswanya secara serius.salah satu bidang OSN
                                yang bergengsi yakni OSN Matematika.
                            </p><br><br><br>

                            <hr>
                            <h2 id="Seni Musik" align="right">Seni Musik</h2>
                            <hr>
                            <img src="{{ asset('admin/img/musk.jpg') }}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                Ekstra kurikuler Musik adalah kegiatan yang diselenggarakan diluar jam pelajaran yang
                                tercantum dalam susunan program sesuai dengan keadaan dan kebutuhan sekolah. Kegiatan ini
                                dimaksud juga untuk lebih menambah kemampuan perseptual yang meliputi kepekaan idrawi
                                terhadap bunyi dan kreatifitas dalam berkarya dan berimajinasi. Ekstrakurikuler Musik
                                sebagai salah satu kegiatan penyaluran dan pengembangan bakat minat yang dimiliki oleh anak
                                didik.
                            </p><br><br><br>

                            <hr>
                            <h2 id="Bola Basket">Bola Basket</h2>
                            <hr>
                            <img src="{{ asset('admin/img/basket.jpeg') }}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bola basket adalah olahraga bola berkelompok yang terdiri atas
                                dua tim beranggotakan masing-masing lima orang yang saling bertanding mencetak poin dengan
                                memasukkan bola ke dalam keranjang lawan. Bola basket dapat di lapangan terbuka, walaupun
                                pertandingan profesional pada umumnya dilakukan di ruang tertutup. Lapangan pertandingan
                                yang diperlukan juga relatif tidak besar, misal dibandingkan dengan sepak bola. Selain itu,
                                permainan bola basket juga lebih kompetitif karena tempo permainan cenderung lebih cepat
                                jika dibandingkan dengan olahraga bola yang lain, seperti voli dan sepak bola.<br><br>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kegiatan ekstrakurikuler bola basket merupakan salah satu
                                kegiatan di luar jam pelajaran sekolah yang juga banyak digemari peserta didik SDK Sang
                                Timur Tomang. Kegiatan ekskul sebagai wadah untuk menampung, menyalurkan dan membina minat,
                                bakat serta kegemaran peserta didik dalam mengikuti kegiatan ekstrakurikuler olah raga. Hal
                                ini dapat menjadi salah satu motivasi peserta didik dalam mengikuti setiap kegiatan
                                ekstrakurikuler.
                            </p><br>

                            <hr>
                            <h2 id="Sepak Takraw" align="right">Sepak Takraw</h2>
                            <hr>
                            <img src="{{ asset('admin/img/takrow.jpg')}}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bola basket adalah olahraga bola berkelompok yang terdiri atas
                                dua tim beranggotakan masing-masing lima orang yang saling bertanding mencetak poin dengan
                                memasukkan bola ke dalam keranjang lawan. Bola basket dapat di lapangan terbuka, walaupun
                                pertandingan profesional pada umumnya dilakukan di ruang tertutup. Lapangan pertandingan
                                yang diperlukan juga relatif tidak besar, misal dibandingkan dengan sepak bola. Selain itu,
                                permainan bola basket juga lebih kompetitif karena tempo permainan cenderung lebih cepat
                                jika dibandingkan dengan olahraga bola yang lain, seperti voli dan sepak bola.
                            </p><br><br><br><br>

                            <hr>
                            <h2 id="Story Telling">Story Telling</h2>
                            <hr>
                            <img src="{{ asset('admin/img/STORY-TELLING1-1.jpg')}}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salah satu EKSTRAKURIKULER di SMP 2 JEKULO KUDUS adalah STORY
                                TELLING Story Telling adalah salah satu cabang lomba bergengsi dan banyak diminati terutama
                                oleh siswa siswi yang ada di perkotaan karena pada dasarnya banyak dari mereka yang sudah
                                ambil kursus dan les bahkan di luar sekolah.<br>

                                Lomba Story Telling termasuk lomba yang mempunyai tingkat kesulitan yang tinggi karena siswa
                                dituntut, bisa mengucapkan kalimat bahasa inggris dengan benar ( fasih ), bisa menghayati
                                dan memperagakan cerita, bisa memberikan gesture atau bahasa tubuh yang pas sesuai isi
                                cerita, memberikan daya pukau yang tinggi sehingga menarik perhatian dan cerita bisa sampai
                                pada pendengar.<br>

                                Dalam hal ini guru juga dituntut kreatif dan inovatif agar cerita bisa disajikan lebih
                                menarik dan tidak monoton.
                            </p><br>

                            <hr>
                            <h2 id="Seni Tari" align="right">Seni Tari</h2>
                            <hr>
                            <img src="{{ asset('admin/img/tari.png')}}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ekstrakulikuler Seni Tari adalah sebuah wadah untuk
                                memperdalam pengetahuan dan wawasan bagi siswa-siswi SMP 2 JEKULO KUDUS tentang seni tari,
                                baik tari Tradisional, Kreasi maupun Klasik yang ada di Indonesia. Tidak hanya teruntuk bagi
                                yang sudah mempunyai bakat saja tetapi juga terbuka lebar bagi siswa-siswi yang ingin
                                mempelajari tentang “Apa itu Seni Tari”.<br>
                                Tujuan adanya ekstrakulikuler Seni Tari adalah sebagai berikut :
                            <ul>
                                <li>Memelihara dan meningkatkan pengetahuan seni tari melalui kegiatan yang dilaksanakan
                                </li>
                                <li>Wadah para siswa-siswi untuk mengembangkan dan mengekspresikan diri melalui menari</li>
                                <li>Mempung dan mewadahi siswa-siswi yang berbakat dalam seni tari</li>
                            </ul>
                            </p><br><br>

                            <hr>
                            <h2 id="Mading">Mading</h2>
                            <hr>
                            <img src="{{ asset('admin/img/mading.jpg')}}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kegiatan mengelola media sekolah atau kegiatan
                                jurnalistikmerupakan proses pembelajaran yang menarik dan penuh manfaat,kegiatan jurnalistik
                                seperti mengelola media sekolah baik berupabuletin, majalah dinding maupun majalah sekolah
                                yang dilakukan siswaSMP, yang melibatkan para guru sebagai pendamping merupakankegiatan yang
                                mengasyikan dan memberikan banyak kreativitas.
                            </p><br><br><br>

                            <hr>
                            <h2 id="Tata Boga" align="right">Tata Boga</h2>
                            <hr>
                            <img src="{{ asset('admin/img/tata boga.png')}}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ekstrakurikuler Tata Boga merupakan ekstra pilihan untuk siswa
                                kelas 7, 8 dan 9 . Program keterampilan ini sangat dibutuhkan oleh siswa terutama siswa
                                putri. Oleh karenanya perlu adanya perhatian khusus terhadap pembinaan berkelanjutan pada
                                program ekstrakurikuler Tata Boga ini. Kegiatan ekstrakurikuler ini mempunyai tujuan
                                membangun kompetensi baik untuk bekal kehidupan mereka ataupun di bidang wirausaha.
                                Pembinaan kegiatan ekstrakurikuler ini memberi keterampilan melalui berbagai resep masakan,
                                kue, minuman dan sebagainya, yang kemudian dipraktekan bersama-sama.
                            </p><br><br><br><br>

                            <hr>
                            <h2 id="Pramuka">Pramuka</h2>
                            <hr>
                            <img src="{{ asset('admin/img/pramuka.jpg')}}" alt="" align="left" width="30%" hspace="30">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ekstrakurikuler Pramuka adalah salah satu kegiatan di sekolah
                                yang bertujuan untuk mengembangkan jiwa kepemimpinan, kemandirian, keberanian, kerjasama,
                                dan rasa cinta terhadap alam serta lingkungan. Pramuka juga mengajarkan nilai-nilai
                                kejujuran, disiplin, tanggung jawab, dan kepedulian sosial kepada para pesertanya. Berikut
                                adalah deskripsi lebih rinci tentang ekstrakurikuler Pramuka:

                            <ol>
                                <li>Tujuan: Ekstrakurikuler Pramuka memiliki beberapa tujuan utama, antara lain:</li>
                                <ul>
                                    <li>Mengembangkan kepribadian yang tangguh dan berwawasan lingkungan.</li>
                                    <li>Membentuk karakter yang berkualitas, seperti disiplin, kerjasama, kejujuran, dan
                                        tanggung jawab.</li>
                                    <li>Mengembangkan keterampilan hidup di alam bebas dan pengetahuan tentang alam serta
                                        lingkungan.</li>
                                    <li>Membentuk jiwa kepemimpinan yang kuat dan mampu menghadapi tantangan.</li>
                                </ul><br><br>
                                <li>Kegiatan: Ekstrakurikuler Pramuka melibatkan sejumlah kegiatan yang dirancang untuk
                                    mencapai tujuan-tujuan tersebut. Beberapa kegiatan yang umum dilakukan antara lain:</li>
                                <ul>
                                    <li>Kemah: Peserta pramuka mendirikan tenda, mempelajari teknik survival, memasak di
                                        alam terbuka, dan belajar menghargai alam. </li>
                                    <li>Pelatihan keterampilan: Peserta pramuka diajarkan berbagai keterampilan, seperti
                                        simpul tali, peta dan kompas, kegiatan pertolongan pertama, kegiatan panjat tebing,
                                        dan kegiatan pendakian gunung.</li>
                                    <li>Pelayanan masyarakat: Pramuka sering terlibat dalam kegiatan sosial, seperti
                                        gotong-royong membersihkan lingkungan, mengadakan donor darah, mengunjungi panti
                                        asuhan, dan kegiatan lain yang bermanfaat bagi masyarakat sekitar.</li>
                                </ul>
                            </ol>
                            </p><br>
                            <hr>
                            <h2 id="OSN IPA" align="right">OSN IPA</h2>
                            <hr>
                            <img src="{{ asset('admin/img/osn.jpg')}}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ekstrakurikuler OSN IPA merupakan ekstrakurikuler yang
                                diadakan untuk mempersiapkan olimpiade sains khususnya untuk Ilmu Pengetahuan Alam.
                                Mempersiapkan peserta didik siap bersaing dalam ajang perlombaan non akademik maupun
                                akademik di tingkat Kabupaten, Provinsi dan Tingkat di atasnya.
                            </p><br><br><br><br>

                            <hr>
                            <h2 id="OSN IPS">OSN IPS</h2>
                            <hr>
                            <img src="{{ asset('admin/img/osn.jpg')}}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ekstrakurikuler OSN IPS ini menjadi wadah bagi siswa yang
                                berminat untuk mendalami ilmu-ilmu sosial. Dengan pelatih handal , SMP YPVDP berusaha untuk
                                selalu menang dalam ajang OSN IPS
                            </p><br><br><br><br>
                            <hr>
                            <h2 id="Futsal" align="right">Futsal</h2>
                            <hr>
                            <img src="{{ asset('admin/img/futsal.jpg')}}" alt="" align="right" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Futsal adalah salah satu olahraga paling populer di kalangan anak muda sekarang, karena olahraga ini adalah turunan dari sepak bola tapi dengan jumlah pemain yang lebih sedikit dan luas lapangan yang lebih kecil.Ekstrakurikuler futsal diadakan dengan tujuan menyediakan wadah untuk siswa menyalurkan hobinya dan menghadirkan corak positif kepada para siswa yaitu sifat-sifat sportifitas serta mencetak bibit-bibit baru olahragawan yang berprestasi di tingkat lokal, nasional maupun internasional.
                            </p><br><br><br><br>

                            <hr>
                            <h2 id="Seni Baca Al-Qur'an">Seni Baca Al-Qur'an</h2>
                            <hr>
                            <img src="{{ asset('admin/img/Agama.png')}}" alt="" align="left" width="30%" hspace="10">
                            <p align="justify">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;seni Baca Al-Qur'an merupakan extrakurikuler pilian bagi seluruh peserta didik kelas 7,8 dan 9.
                            </p><br><br><br><br>

                        </div>
                    </div>
                </main>
            </div>
            <script>
                // Tampilkan tombol ketika halaman di-scroll lebih dari 100px
                window.onscroll = function() { scrollFunction() };
                function scrollFunction() {
                    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                        document.getElementById("myBtn").style.display = "block";
                    } else {
                        document.getElementById("myBtn").style.display = "none";
                    }
                }

                // Fungsi scroll ke atas
                function topFunction() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                }
                </script>
    </body>
@endsection
