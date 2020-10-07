<table align="center" width="100%" style="border:1px solid black">
    <thead>
    <tr>
    <td colspan="2">XIN CHÀO</td>    
    </tr>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dossiers as $dossier)
        <tr>
            <td>{{ $dossier->ID_Dossier }}</td>
            <td>{{ $dossier->dossier_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>