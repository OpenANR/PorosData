import os
import re

apps = [
    {
        "name": "E-Journal",
        "path": "resources/views/PorosDataHome/SubMenuApplication/E-Journal/login.blade.php",
        "title": "Login - E-Journal - PorosData",
        "desc_meta": "Halaman Login E-Journal - PorosData.",
        "portal_name": "Portal E-Journal",
        "desc": "\"E-Journal adalah platform digital untuk mencatat, mengelola, dan memantau jurnal kegiatan mengajar guru secara terstruktur dan efisien.\"",
        "auth_title": "E-Journal Authentication",
        "welcome": "Welcome back to E-Journal",
        "action": "{{ url('/porosdata/e-journal/login') }}",
        "input_name": "username_or_duk",
        "input_label": "Username / Kode DUK",
        "input_placeholder": "Masukkan Username / Kode DUK",
    },
    {
        "name": "PortalNilai",
        "path": "resources/views/PorosDataHome/SubMenuApplication/PortalNilai/login.blade.php",
        "title": "Login - Portal Nilai - PorosData",
        "desc_meta": "Halaman Login Portal Nilai - PorosData.",
        "portal_name": "Portal Nilai",
        "desc": "\"Portal Nilai adalah sistem manajemen penilaian siswa yang memudahkan guru dalam menginput, mengelola, dan mendistribusikan laporan hasil belajar secara akurat dan transparan.\"",
        "auth_title": "Portal Nilai Authentication",
        "welcome": "Welcome back to Portal Nilai",
        "action": "{{ url('/porosdata/portalnilai/login') }}",
        "input_name": "username",
        "input_label": "Username",
        "input_placeholder": "Masukkan username Anda",
    },
    {
        "name": "DataSiswa",
        "path": "resources/views/PorosDataHome/SubMenuApplication/DataSiswa/login.blade.php",
        "title": "Login - Data Siswa - PorosData",
        "desc_meta": "Halaman Login Data Siswa - PorosData.",
        "portal_name": "Portal Data Siswa",
        "desc": "\"Data Siswa merupakan pusat informasi data diri dan riwayat akademik peserta didik yang terintegrasi untuk mendukung administrasi sekolah yang tertib.\"",
        "auth_title": "Data Siswa Authentication",
        "welcome": "Welcome back to Data Siswa",
        "action": "{{ url('/porosdata/datasiswa/login') }}",
        "input_name": "username_or_duk",
        "input_label": "Username / Kode DUK",
        "input_placeholder": "Masukkan Username / Kode DUK",
    },
    {
        "name": "PortalSiswa",
        "path": "resources/views/PorosDataHome/SubMenuApplication/PortalSiswa/login.blade.php",
        "title": "Login - Portal Siswa - PorosData",
        "desc_meta": "Halaman Login Portal Siswa - PorosData.",
        "portal_name": "Portal Siswa",
        "desc": "\"Portal Siswa adalah layanan mandiri bagi siswa untuk mengakses informasi akademik, jadwal, nilai, dan absensi secara real-time dan mudah.\"",
        "auth_title": "Portal Siswa Authentication",
        "welcome": "Welcome back to Portal Siswa",
        "action": "{{ url('/porosdata/portalsiswa/login') }}",
        "input_name": "username_or_nisn",
        "input_label": "Username / NISN",
        "input_placeholder": "Masukkan Username / NISN",
    },
    {
        "name": "PortalPKL",
        "path": "resources/views/PorosDataHome/SubMenuApplication/PortalPKL/login.blade.php",
        "title": "Login - Portal PKL - PorosData",
        "desc_meta": "Halaman Login Portal PKL - PorosData.",
        "portal_name": "Portal PKL",
        "desc": "\"Portal PKL memfasilitasi pengelolaan program Praktik Kerja Lapangan, mulai dari pendaftaran, penempatan, hingga pemantauan kegiatan siswa di dunia industri.\"",
        "auth_title": "Portal PKL Authentication",
        "welcome": "Welcome back to Portal PKL",
        "action": "{{ url('/porosdata/portal-pkl/login') }}",
        "input_name": "username",
        "input_label": "Username",
        "input_placeholder": "Masukkan username Anda",
    }
]

template_path = "resources/views/auth/login.blade.php"
with open(template_path, 'r', encoding='utf-8') as f:
    template = f.read()

for app in apps:
    content = template
    # Replace Title
    content = re.sub(r'<title>.*?</title>', f'<title>{app["title"]}</title>', content)
    # Replace Meta Description
    content = re.sub(r'<meta name="description" content=".*?">', f'<meta name="description" content="{app["desc_meta"]}">', content)
    # Replace Portal Name
    content = content.replace("Portal Sekolah SD", app["portal_name"])
    # Replace Description
    content = re.sub(r'"PorosData adalah platform pusat manajemen data dan administrasi sekolah terpadu yang dirancang untuk memudahkan pengelolaan informasi akademik, data siswa, kepegawaian, serta laporan aktivitas sekolah secara efisien dan real-time."', app["desc"], content)
    # Replace Auth Title
    content = content.replace("PorosData Authentication", app["auth_title"])
    # Replace Welcome Text
    content = content.replace("Welcome back to PorosData", app["welcome"])
    # Replace Form Action
    content = re.sub(r'<form action="\{\{ url\(\'/login\'\) \}\}" method="POST" class="space-y-5">', f'<form action="{app["action"]}" method="POST" class="space-y-5">', content)
    
    # Replace Username label and input if needed
    if app["input_name"] != "username":
        content = content.replace(">\\n                            Username\\n                        </label>", f">\\n                            {app['input_label']}\\n                        </label>")
        content = content.replace("name=\"username\"", f"name=\"{app['input_name']}\"")
        content = content.replace("id=\"username\"", f"id=\"{app['input_name']}\"")
        content = content.replace("value=\"{{ old('username') }}\"", f"value=\"{{{{ old('{app['input_name']}') }}}}\"")
        content = content.replace("@error('username')", f"@error('{app['input_name']}')")
        content = content.replace("placeholder=\"Masukkan username Anda\"", f"placeholder=\"{app['input_placeholder']}\"")

    with open(app["path"], 'w', encoding='utf-8') as f:
        f.write(content)
        print(f"Updated {app['path']}")
