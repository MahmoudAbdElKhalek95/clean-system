    @if($rows)
      @foreach($rows as $row)
        <tr class="open-link" data-link="{{ $row[1] }}">
        <td>{{ htmlspecialchars($row[0],ENT_NOQUOTES) }}</td>
        <td>{{ htmlspecialchars($row[2],ENT_NOQUOTES) }}</td>
        </tr>
      @endforeach
    @else
      <tr><td colspan="2"><small>فارغ</small></td></tr>
    @endif
