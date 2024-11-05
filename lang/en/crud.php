<?php

return [
    'users' => [
        'inputs' => [
            'fistname' => [
                'label' => 'Fistname',
                'placeholder' => 'Fistname',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Password',
            ],
            'age' => [
                'label' => 'Age',
                'placeholder' => 'Age',
            ],
            'date_of_birth' => [
                'label' => 'Date of birth',
                'placeholder' => 'Date of birth',
            ],
            'place_of_birth' => [
                'label' => 'Place of birth',
                'placeholder' => 'Place of birth',
            ],
            'phone_number' => [
                'label' => 'Telephone',
                'placeholder' => 'Telephone',
            ],
            'cni' => [
                'label' => 'Cni',
                'placeholder' => 'Cni',
            ],
            'address' => [
                'label' => 'Address',
                'placeholder' => 'Address',
            ],
            'civility' => [
                'label' => 'Civility',
                'placeholder' => 'Civility',
            ],
            'gender' => [
                'label' => 'Gender',
                'placeholder' => 'Gender',
            ],
            'firstname' => [
                'label' => 'Firstname',
                'placeholder' => 'Firstname',
            ],
            'phone_number' => [
                'label' => 'Phone number',
                'placeholder' => 'Phone number',
            ],
            'lastname' => [
                'label' => 'Lastname',
                'placeholder' => 'Lastname',
            ],
        ],
        'filament' => [
            'fistname' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'email' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'password' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'lastname' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'age' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'date_of_birth' => [
                'helper_text' => '',
                'label' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
            'place_of_birth' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'phone_number' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'cni' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'address' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'civility' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'gender' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'firstname' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'phone_number' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
        ],
        'itemTitle' => 'User',
        'collectionTitle' => 'Users',
    ],
    'patients' => [
        'itemTitle' => 'Patient',
        'collectionTitle' => 'Patients',
        'inputs' => [
            'matricule' => [
                'label' => 'Matricule',
                'placeholder' => 'Matricule',
            ],
            'medical_histroy' => [
                'label' => 'Medical histroy',
                'placeholder' => 'Medical histroy',
            ],
            'user_id' => [
                'label' => 'User',
                'placeholder' => 'User id',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
        ],
        'filament' => [
            'matricule' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'medical_histroy' => [
                'helper_text' => '',
                'label' => '',
            ],
            'user_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
    ],
    'doctors' => [
        'itemTitle' => 'Doctor',
        'collectionTitle' => 'Doctors',
        'inputs' => [
            'matricule' => [
                'label' => 'Matricule',
                'placeholder' => 'Matricule',
            ],
            'speciality' => [
                'label' => 'Speciality',
                'placeholder' => 'Speciality',
            ],
            'num_ordre' => [
                'label' => 'Num ordre',
                'placeholder' => 'Num ordre',
            ],
            'user_id' => [
                'label' => 'User',
                'placeholder' => 'User id',
            ],
            'entity_id' => [
                'label' => 'Entity',
                'placeholder' => 'Entity id',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
        ],
        'filament' => [
            'matricule' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'speciality' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'num_ordre' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'user_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'entity_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
    ],
    'doctorPatients' => [
        'itemTitle' => 'Doctor Patient',
        'collectionTitle' => 'Doctor Patients',
        'inputs' => [
            'patient_id' => [
                'label' => 'Patient ',
                'placeholder' => 'Patient id',
            ],
            'doctor_id' => [
                'label' => 'Doctor',
                'placeholder' => 'Doctor id',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
        ],
        'filament' => [
            'patient_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
    ],
    'entities' => [
        'inputs' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name',
            ],
            'address' => [
                'label' => 'Address',
                'placeholder' => 'Address',
            ],
            'type' => [
                'label' => 'Type',
                'placeholder' => 'Type',
            ],
            'phone_number' => [
                'label' => 'Telephone',
                'placeholder' => 'Telephone',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Email',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
        ],
        'filament' => [
            'name' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'address' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'type' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'phone_number' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'email' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
        'itemTitle' => 'Entity',
        'collectionTitle' => 'Entities',
    ],
    'parameters' => [
        'inputs' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name',
            ],
            'max_value' => [
                'label' => 'Max value',
                'placeholder' => 'Max value',
            ],
            'min_value' => [
                'label' => 'Min value',
                'placeholder' => 'Min value',
            ],
            'unity' => [
                'label' => 'Unity',
                'placeholder' => 'Unity',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
            'notification_min' => [
                'label' => 'Notification min',
                'placeholder' => 'Notification min',
            ],
            'notification_max' => [
                'label' => 'Notification max',
                'placeholder' => 'Notification max',
            ],
        ],
        'filament' => [
            'name' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'max_value' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'min_value' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'unity' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
            'notification_min' => [
                'helper_text' => '',
                'label' => '',
            ],
            'notification_max' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
        'itemTitle' => 'Parameter',
        'collectionTitle' => 'Parameters',
    ],
    'monitorings' => [
        'inputs' => [
            'patient_id' => [
                'label' => 'Patient id',
                'placeholder' => 'Patient id',
            ],
            'parameter_id' => [
                'label' => 'Parameter id',
                'placeholder' => 'Parameter id',
            ],
            'comments' => [
                'label' => 'Comments',
                'placeholder' => 'Comments',
            ],
            'value' => [
                'label' => 'Value',
                'placeholder' => 'Value',
            ],
            'deleted_at' => [
                'label' => 'Deleted at',
                'placeholder' => 'Deleted at',
            ],
            'comments_patients' => [
                'label' => 'Comments patients',
                'placeholder' => 'Comments patients',
            ],
            'dateofsample' => [
                'label' => 'Dateofsample',
                'placeholder' => 'Dateofsample',
            ],
            'comments_doctor' => [
                'label' => 'Comments doctor',
                'placeholder' => 'Comments doctor',
            ],
        ],
        'filament' => [
            'patient_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'parameter_id' => [
                'helper_text' => '',
                'loading_message' => '',
                'no_result_message' => '',
                'search_message' => '',
                'label' => '',
            ],
            'comments' => [
                'helper_text' => '',
                'label' => '',
            ],
            'value' => [
                'helper_text' => '',
                'label' => '',
                'description' => '',
            ],
            'deleted_at' => [
                'helper_text' => '',
                'label' => '',
            ],
            'comments_patients' => [
                'helper_text' => '',
                'label' => '',
            ],
            'dateofsample' => [
                'helper_text' => '',
                'label' => '',
            ],
            'comments_doctor' => [
                'helper_text' => '',
                'label' => '',
            ],
        ],
        'itemTitle' => 'Monitoring',
        'collectionTitle' => 'Monitorings',
    ],
];
