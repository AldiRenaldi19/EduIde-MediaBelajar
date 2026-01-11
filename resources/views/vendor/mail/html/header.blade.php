@props(['url'])
<tr>
    <td class="header" style="padding: 40px 0; text-align: center;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                <tr>
                    <td style="vertical-align: middle;">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 8px;">
                    </td>
                    <td style="vertical-align: middle; padding-left: 12px;">
                        <span style="font-size: 26px; font-weight: 800; color: #6366f1; letter-spacing: -1px; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">
                            EduIde
                        </span>
                    </td>
                </tr>
            </table>
        </a>
    </td>
</tr>