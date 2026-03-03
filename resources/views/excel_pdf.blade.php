<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;

            font-size: {
                    {
                    $settings['font_size']
                }
            }

            px;
            color: #1a202c;
            background: #fff;
        }

        /* ── Document header ── */
        .doc-header {
            width: 100%;

            border-bottom: 2px solid {
                    {
                    $settings['accent_color']
                }
            }

            ;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .doc-title {
            font-size: {
                    {
                    $settings['font_size']+6
                }
            }

            px;
            font-weight: bold;

            color: {
                    {
                    $settings['accent_color']
                }
            }

            ;
        }

        .doc-meta {
            font-size: {
                    {
                    max(7, $settings['font_size'] - 2)
                }
            }

            px;
            color: #718096;
            margin-top: 2px;
        }

        .doc-date {
            font-size: {
                    {
                    max(7, $settings['font_size'] - 2)
                }
            }

            px;
            color: #718096;
            text-align: right;
            margin-top: 2px;
        }

        /* ── Sheet label ── */
        .sheet {
            margin-bottom: 20px;
        }

        .sheet-title {
            font-size: {
                    {
                    $settings['font_size']+1
                }
            }

            px;
            font-weight: bold;
            color: #fff;

            background: {
                    {
                    $settings['accent_color']
                }
            }

            ;
            padding: 4px 8px;
            margin-bottom: 0;
        }

        .page-break {
            page-break-after: always;
        }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            margin-bottom: 8px;
        }

        /* Header row */
        .row-header td {
            background: {
                    {
                    $settings['accent_color']
                }
            }

            ;
            color: #ffffff;
            font-weight: bold;

            font-size: {
                    {
                    max(7, $settings['font_size'] - 1)
                }
            }

            px;
            padding: 5px 7px;
            white-space: nowrap;

            @if ($settings['show_borders']) border: 1px solid {
                    {
                    $settings['accent_color']
                }
            }

            ;
            @endif
        }

        /* Data rows */
        .row-even td {
            background: #f4f6fb;
            padding: 4px 7px;

            font-size: {
                    {
                    max(7, $settings['font_size'] - 1)
                }
            }

            px;
            color: #2d3748;
            word-break: break-word;
            @if ($settings['show_borders']) border: 1px solid #d8e0ef;
            @endif
        }

        .row-odd td {
            background: #ffffff;
            padding: 4px 7px;

            font-size: {
                    {
                    max(7, $settings['font_size'] - 1)
                }
            }

            px;
            color: #2d3748;
            word-break: break-word;
            @if ($settings['show_borders']) border: 1px solid #d8e0ef;
            @endif
        }

        /* ── Footer ── */
        .doc-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            margin-top: 12px;

            font-size: {
                    {
                    max(6, $settings['font_size'] - 3)
                }
            }

            px;
            color: #a0aec0;
        }
    </style>
</head>

<body>

    @foreach ($sheets as $sheet)

    <div class="sheet {{ !$loop->last ? 'page-break' : '' }}">

        @if (count($sheets) > 1)
        <div class="sheet-title">{{ $sheet['title'] }}</div>
        @endif

        <table>
            @foreach ($sheet['rows'] as $ri => $row)
            @if ($ri === 0 && $settings['header_row'])
            {{-- Header row --}}
            <tr class="row-header">
                @foreach ($row as $cell)
                <td>{{ $cell ?? '' }}</td>
                @endforeach
            </tr>
            @else
            @php
            $dataIndex = $settings['header_row'] ? $ri : $ri + 1;
            $rowClass = ($settings['striped_rows'] && $dataIndex % 2 === 0)
            ? 'row-even' : 'row-odd';
            @endphp
            <tr class="{{ $rowClass }}">
                @foreach ($row as $cell)
                <td>{{ $cell ?? '' }}</td>
                @endforeach
            </tr>
            @endif
            @endforeach
        </table>

    </div>

    @endforeach



</body>

</html>
