<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3498db; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; margin: 20px 0; }
        .label { font-weight: bold; color: #555; }
        .button { background: #3498db; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📧 Pesan Baru dari Contact Form</h2>
        </div>

        <div class="content">
            <p><span class="label">Nama:</span> {{ $contact->name }}</p>
            <p><span class="label">Email:</span> {{ $contact->email }}</p>
            <p><span class="label">Instansi:</span> {{ $contact->institution ?? '-' }}</p>
            <p><span class="label">Pesan:</span></p>
            <p style="background: white; padding: 15px; border-left: 4px solid #3498db;">
                {{ $contact->message }}
            </p>

            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="button">
                Lihat Detail & Review
            </a>
        </div>
    </div>
</body>
</html>
