<x-app-layout>
  <x-slot name="title">{{ $student->name }}</x-slot>

  <div class="page-header">
    <div>
      <h2 class="page-title">{{ $student->name }}</h2>
      <p class="page-subtitle">Roll No: {{ $student->roll_no }} &bull; Class {{ $student->class }}{{ $student->section ? '-'.$student->section : '' }}</p>
    </div>
    <div style="display:flex; gap:10px;">
      <a href="{{ route('students.edit', $student) }}" class="btn btn-outline" id="edit-student-btn">Edit</a>
      <a href="{{ route('marks.create', ['student_id' => $student->id]) }}" class="btn btn-outline" id="add-marks-btn">+ Add Marks</a>
      <a href="{{ route('remedial.create', ['student_id' => $student->id]) }}" class="btn btn-primary" id="assign-remedial-btn">+ Assign Remedial</a>
    </div>
  </div>

  {{-- Info + Stats row --}}
  <div style="display:grid; grid-template-columns: 280px 1fr; gap:20px; margin-bottom:24px;">

    {{-- Info Card --}}
    <div class="card">
      <div style="text-align:center; padding:16px 0 24px;">
        <div class="student-avatar" style="width:64px;height:64px;font-size:22px;margin:0 auto 12px;">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
        <div class="student-name" style="font-size:17px;">{{ $student->name }}</div>
        <div class="student-roll">{{ $student->email ?? '—' }}</div>
        <div style="margin-top:12px;">
          @if(!$student->has_marks)
            <span class="badge badge-muted">Not Evaluated</span>
          @elseif($student->is_slow_learner)
            <span class="badge badge-error">⚠ Slow Learner</span>
          @elseif($student->average_percentage >= 60)
            <span class="badge badge-success">✓ Good Performance</span>
          @else
            <span class="badge badge-warning">~ At Risk</span>
          @endif
        </div>
      </div>

      <div style="border-top:1px solid var(--border); padding-top:16px; display:flex; flex-direction:column; gap:12px;">
        @foreach([['Roll No', $student->roll_no], ['Class', $student->class.($student->section ? '-'.$student->section : '')], ['Gender', ucfirst($student->gender ?? '—')], ['DOB', $student->dob ? $student->dob->format('d M Y') : '—'], ['Phone', $student->phone ?? '—'], ['Guardian', $student->guardian_name ?? '—']] as [$label, $val])
        <div style="display:flex; justify-content:space-between; font-size:13px;">
          <span style="color:var(--text-muted); font-weight:500;">{{ $label }}</span>
          <span style="font-weight:600;">{{ $val }}</span>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Performance Stats --}}
    <div style="display:flex; flex-direction:column; gap:16px;">
      {{-- Average bar --}}
      <div class="card">
        <div class="card-title" style="margin-bottom:16px;">Overall Performance</div>
        @if($student->has_marks)
            @php $avg = $student->average_percentage; $color = $student->performance_color; @endphp
            <div style="display:flex; align-items:center; gap:16px;">
              <div style="font-family:'Poppins',sans-serif; font-size:48px; font-weight:700; color:{{ $color }}; line-height:1;">{{ $avg }}%</div>
              <div style="flex:1;">
                <div class="progress-bar" style="height:10px;">
                  <div class="progress-fill" style="width:{{ $avg }}%; background:{{ $color }};"></div>
                </div>
                <div style="font-size:13px; color:var(--text-muted); margin-top:8px;">{{ $student->performance_label }} — based on {{ $student->marks->count() }} marks entries</div>
              </div>
            </div>
        @else
            <div style="text-align:center; padding:20px;">
                <div style="font-size:14px; color:var(--text-muted); margin-bottom:12px;">No performance data available yet.</div>
                <a href="{{ route('marks.create', ['student_id' => $student->id]) }}" class="btn btn-primary btn-sm">+ Add First Mark</a>
            </div>
        @endif
      </div>

      {{-- Subject marks table --}}
      <div class="card" style="flex:1;">
        <div class="card-title" style="margin-bottom:16px;">Subject-wise Marks</div>
        <div class="table-wrapper">
          <table class="pmrs-table">
            <thead>
              <tr><th>Subject</th><th>Exam</th><th>Marks</th><th>%</th><th>Result</th></tr>
            </thead>
            <tbody>
              @forelse($student->marks as $mark)
              <tr>
                <td>{{ $mark->subject->name ?? '—' }}</td>
                <td><span class="badge badge-muted">{{ str_replace('_', ' ', ucfirst($mark->exam_type)) }}</span></td>
                <td>{{ $mark->marks_obtained }} / {{ $mark->max_marks }}</td>
                <td style="font-weight:600;">{{ $mark->percentage }}%</td>
                <td>
                  @if($mark->is_pass)
                    <span class="badge badge-success">Pass</span>
                  @else
                    <span class="badge badge-error">Fail</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center; padding:24px; color:var(--text-muted);">No marks recorded yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Remedial Actions --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">Remedial Actions</div>
      <a href="{{ route('remedial.create', ['student_id' => $student->id]) }}" class="btn btn-outline btn-sm">+ Add Action</a>
    </div>
    <div class="table-wrapper">
      <table class="pmrs-table">
        <thead><tr><th>Title</th><th>Type</th><th>Scheduled</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($student->remedialActions as $action)
          <tr>
            <td>{{ $action->title }}</td>
            <td><span class="badge badge-primary">{{ str_replace('_', ' ', ucfirst($action->action_type)) }}</span></td>
            <td>{{ $action->scheduled_date ? $action->scheduled_date->format('d M Y') : '—' }}</td>
            <td>
              <span class="badge" style="background:{{ $action->status_badge_color }}20; color:{{ $action->status_badge_color }};">
                {{ ucfirst(str_replace('_', ' ', $action->status)) }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center; padding:24px; color:var(--text-muted);">No remedial actions assigned.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-app-layout>
