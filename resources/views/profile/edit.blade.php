<x-app-layout>
    <x-slot name="header">
        <h2 class="page-header-title">Profile Settings</h2>
    </x-slot>

    <style>
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r3);
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.03);
            margin-bottom: 24px;
        }
        .card-header {
            display: flex; align-items: center; gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--accent-bg);
            display: flex; align-items: center; justify-content: center;
        }
        .card-icon svg { width: 16px; height: 16px; color: var(--accent); }
        .card-icon.danger { background: var(--red-bg); }
        .card-icon.danger svg { color: var(--red); }
        .card-title {
            font-size: 15px; font-weight: 600; color: var(--text);
            margin: 0 0 2px; letter-spacing: -.01em;
        }
        .card-subtitle { font-size: 12px; color: var(--text-3); margin: 0; }
        .card-body { padding: 20px; }

        .field { margin-bottom: 20px; }
        .field-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-2); margin-bottom: 6px; }
        .field-input {
            width: 100%; padding: 10px 14px;
            background: var(--surface); border: 1px solid var(--border-md);
            border-radius: var(--r); font-size: 14px; color: var(--text);
            outline: none; transition: border-color .15s, box-shadow .15s;
        }
        .field-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,86,219,0.12); }
        .field-error { font-size: 12px; color: var(--red); margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; border-radius: var(--r);
            font-size: 13px; font-weight: 600; color: #fff;
            border: none; cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,.1);
            transition: opacity .12s, transform .12s;
        }
        .btn:hover { opacity: .92; transform: translateY(-1px); }
        .btn svg { width: 14px; height: 14px; }
        .btn-primary { background: var(--accent); box-shadow: 0 2px 6px rgba(26,86,219,.25); }
        .btn-danger  { background: var(--red); box-shadow: 0 2px 6px rgba(220,38,38,.25); }

        .alert {
            padding: 10px 14px; border-radius: var(--r);
            font-size: 13px; margin-top: 12px;
            border: 1px solid;
        }
        .alert-success { background: var(--green-bg); color: var(--green); border-color: rgba(14,159,110,.2); }
        .alert-warning { background: var(--amber-bg); color: var(--amber); border-color: rgba(217,119,6,.2); }
    </style>

    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')
    @include('profile.partials.delete-user-form')
</x-app-layout>