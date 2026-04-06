# eKomuniti.app API Reference

## Base URL

```
/api
```

---

## 1. Authentication

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `POST` | `/api/auth/login` | Login dengan email & password |
| `POST` | `/api/auth/register` | Daftar akaun baru |
| `POST` | `/api/auth/logout` | Logout user |
| `POST` | `/api/auth/forgot-password` | Request reset password |

### POST `/api/auth/login`

**Request:**
```json
{
    "email": "rizky@example.com",
    "password": "password"
}
```

**Response (200):**
```json
{
    "token": "1|abc123...",
    "user": {
        "id": 1,
        "name": "Rizky Ahmad",
        "email": "rizky@example.com",
        "phone": "+60123456789",
        "avatar_url": null
    }
}
```

### POST `/api/auth/register`

**Request:**
```json
{
    "name": "Rizky Ahmad",
    "email": "rizky@example.com",
    "phone": "+60123456789",
    "password": "password",
    "password_confirmation": "password"
}
```

**Response (201):**
```json
{
    "token": "1|abc123...",
    "user": {
        "id": 1,
        "name": "Rizky Ahmad",
        "email": "rizky@example.com",
        "phone": "+60123456789",
        "avatar_url": null
    }
}
```

### POST `/api/auth/logout`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "Logged out successfully"
}
```

### POST `/api/auth/forgot-password`

**Request:**
```json
{
    "email": "rizky@example.com"
}
```

**Response (200):**
```json
{
    "message": "Password reset link sent to your email"
}
```

---

## 2. User / Profile

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/user/profile` | Get current user profile |
| `PUT` | `/api/user/profile` | Update profile |
| `PUT` | `/api/user/settings` | Update settings |

### GET `/api/user/profile`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "name": "Rizky Ahmad",
    "email": "rizky@example.com",
    "phone": "+60123456789",
    "avatar_url": null,
    "initials": "RA",
    "created_at": "2024-01-15T08:00:00Z"
}
```

### PUT `/api/user/profile`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "name": "Rizky Ahmad",
    "email": "rizky@example.com",
    "phone": "+60123456789"
}
```

**Response (200):**
```json
{
    "id": 1,
    "name": "Rizky Ahmad",
    "email": "rizky@example.com",
    "phone": "+60123456789",
    "avatar_url": null,
    "initials": "RA"
}
```

### PUT `/api/user/settings`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "notification_enabled": true,
    "language": "ms"
}
```

**Response (200):**
```json
{
    "message": "Settings updated",
    "settings": {
        "notification_enabled": true,
        "language": "ms"
    }
}
```

---

## 3. Communities

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/communities` | List semua communities |
| `GET` | `/api/communities/{id}` | Detail community |
| `GET` | `/api/communities/{id}/qr` | QR Code Jemputan Komuniti |
| `GET` | `/api/communities/{id}/members` | Senarai members |
| `GET` | `/api/communities/{id}/feed` | Community feed/posts |
| `GET` | `/api/user/communities` | Communities yang user join |
| `POST` | `/api/communities/{id}/join` | Join community |
| `DELETE` | `/api/communities/{id}/leave` | Leave community |

### GET `/api/communities`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `search` (optional) — carian nama community
- `page` (optional) — pagination

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Taman Melati Residents",
            "type": "Housing Area",
            "icon": "solar:city-linear",
            "icon_bg": "bg-blue-50",
            "icon_color": "text-blue-500",
            "member_count": 128,
            "status": "active",
            "is_joined": true
        },
        {
            "id": 2,
            "name": "Weekend Badminton",
            "type": "Sports",
            "icon": "solar:dumbbell-large-minimalistic-linear",
            "icon_bg": "bg-orange-50",
            "icon_color": "text-orange-500",
            "member_count": 42,
            "status": "active",
            "is_joined": true
        },
        {
            "id": 3,
            "name": "Monthly Book Club",
            "type": "Hobby",
            "icon": "solar:book-linear",
            "icon_bg": "bg-gray-100",
            "icon_color": "text-gray-400",
            "member_count": 15,
            "status": "pending",
            "is_joined": false
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 3
    }
}
```

### GET `/api/communities/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "name": "Taman Melati Residents",
    "type": "Housing Area",
    "description": "Welcome to Taman Melati Residents. We are dedicated to maintaining a safe, clean, and friendly neighborhood for all residents.",
    "icon": "solar:city-linear",
    "icon_bg": "bg-blue-50",
    "icon_color": "text-blue-500",
    "member_count": 128,
    "established_year": 2018,
    "status": "active",
    "is_joined": true
}
```

### GET `/api/communities/{id}/qr`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "share_link": "https://ekomuniti.app/persatuan/abc123",
    "key_reference": "abc123",
    "custom_link": null
}
```

**Response (404):**
```json
{
    "message": "Komuniti tidak ditemukan"
}
```

**Keterangan:**
- `share_link`: URL penuh untuk dikongsi (termasuk custom_link jika ada)
- `key_reference`: Kunci rujukan unik untuk komuniti
- `custom_link`: Pautan tersuai (null jika tidak ditetapkan)

### GET `/api/communities/{id}/members`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Rizky Ahmad",
            "initials": "RA",
            "avatar_url": null,
            "role": "admin"
        },
        {
            "id": 2,
            "name": "Siti Nurhaliza",
            "initials": "SN",
            "avatar_url": null,
            "role": "member"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "total": 128
    }
}
```

### GET `/api/communities/{id}/feed`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "author": {
                "id": 1,
                "name": "Admin",
                "initials": "AD"
            },
            "content": "Reminder: Community BBQ this Saturday!",
            "created_at": "2024-10-22T10:00:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 1
    }
}
```

### GET `/api/user/communities`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Taman Melati Residents",
            "type": "Housing Area",
            "icon": "solar:city-linear",
            "icon_bg": "bg-blue-50",
            "icon_color": "text-blue-500",
            "member_count": 128,
            "status": "active"
        },
        {
            "id": 2,
            "name": "Weekend Badminton",
            "type": "Sports",
            "icon": "solar:dumbbell-large-minimalistic-linear",
            "icon_bg": "bg-orange-50",
            "icon_color": "text-orange-500",
            "member_count": 42,
            "status": "active"
        }
    ]
}
```

### POST `/api/communities/{id}/join`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "Joined community successfully"
}
```

### DELETE `/api/communities/{id}/leave`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "Left community successfully"
}
```

---

## 4. Announcements

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/announcements` | List announcements |
| `GET` | `/api/announcements/{id}` | Detail announcement |

### GET `/api/announcements`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `community_id` (optional) — filter by community
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Water Supply Disruption",
            "description": "Scheduled maintenance for pipe repairs in Block A-C.",
            "icon": "solar:danger-triangle-linear",
            "icon_bg": "bg-amber-50",
            "icon_color": "text-amber-500",
            "community": {
                "id": 1,
                "name": "Taman Melati"
            },
            "author": "Admin",
            "created_at": "2024-10-24T08:00:00Z",
            "time_ago": "2 hours ago"
        },
        {
            "id": 2,
            "title": "Annual General Meeting 2023",
            "description": "Please join us for the AGM this coming Sunday at the community hall.",
            "icon": "solar:document-text-linear",
            "icon_bg": "bg-purple-50",
            "icon_color": "text-purple-500",
            "community": {
                "id": 1,
                "name": "Taman Melati"
            },
            "author": "Admin",
            "created_at": "2024-10-23T10:00:00Z",
            "time_ago": "Yesterday"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 2
    }
}
```

### GET `/api/announcements/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "title": "Water Supply Disruption",
    "content": "Full announcement content here with all details...",
    "icon": "solar:danger-triangle-linear",
    "icon_bg": "bg-amber-50",
    "icon_color": "text-amber-500",
    "tags": ["Community", "Important"],
    "community": {
        "id": 1,
        "name": "Taman Melati"
    },
    "author": "Admin",
    "created_at": "2024-10-24T08:00:00Z",
    "time_ago": "2 hours ago"
}
```

---

## 5. Activities / Events

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/activities` | List upcoming activities |
| `GET` | `/api/activities/{id}` | Detail activity |
| `POST` | `/api/activities/{id}/rsvp` | RSVP ke activity |
| `DELETE` | `/api/activities/{id}/rsvp` | Cancel RSVP |

### GET `/api/activities`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `community_id` (optional) — filter by community
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Gotong-Royong Perdana",
            "date": "2024-10-24",
            "date_display": {
                "month": "Oct",
                "day": "24"
            },
            "start_time": "08:00",
            "end_time": "12:00",
            "time_display": "8:00 AM - 12:00 PM",
            "location": "Community Hall",
            "community": {
                "id": 1,
                "name": "Taman Melati"
            },
            "is_rsvp": false
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 1
    }
}
```

### GET `/api/activities/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "title": "Gotong-Royong Perdana",
    "description": "Join us for a community cleanup event...",
    "date": "2024-10-24",
    "date_display": {
        "month": "Oct",
        "day": "24"
    },
    "start_time": "08:00",
    "end_time": "12:00",
    "time_display": "8:00 AM - 12:00 PM",
    "location": "Community Hall",
    "community": {
        "id": 1,
        "name": "Taman Melati"
    },
    "author": "Admin",
    "is_rsvp": false,
    "rsvp_count": 24,
    "created_at": "2024-10-20T08:00:00Z"
}
```

### POST `/api/activities/{id}/rsvp`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "RSVP confirmed"
}
```

### DELETE `/api/activities/{id}/rsvp`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "RSVP cancelled"
}
```

---

## 6. Notifications

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/notifications` | List semua notifications |
| `GET` | `/api/notifications/{id}` | Detail notification |
| `PUT` | `/api/notifications/{id}/read` | Mark as read |
| `PUT` | `/api/notifications/read-all` | Mark all as read |

### GET `/api/notifications`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Payment Reminder",
            "preview": "Your security fee for September is overdue. Please pay to avoid penalties.",
            "type": "Payment",
            "is_read": false,
            "created_at": "2024-10-24T09:58:00Z",
            "time_ago": "2m ago"
        },
        {
            "id": 2,
            "title": "New Event Added",
            "preview": "\"Community BBQ\" has been added to the calendar for next Saturday.",
            "type": "Event",
            "is_read": true,
            "created_at": "2024-10-24T09:00:00Z",
            "time_ago": "1h ago"
        },
        {
            "id": 3,
            "title": "Water Disruption Update",
            "preview": "Water disruption scheduled maintenance completed early.",
            "type": "Announcement",
            "is_read": true,
            "created_at": "2024-10-23T10:00:00Z",
            "time_ago": "Yesterday"
        }
    ],
    "unread_count": 1,
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 3
    }
}
```

### GET `/api/notifications/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "title": "Payment Reminder",
    "type": "Payment",
    "icon": "solar:bill-list-linear",
    "icon_bg": "bg-red-50",
    "icon_color": "text-red-500",
    "badge_bg": "bg-red-50",
    "badge_color": "text-red-600",
    "content": [
        "Your security fee for September 2024 is currently overdue. The total amount due is RM50.00.",
        "Please make your payment as soon as possible to avoid any late penalties. A 10% surcharge will be applied after 30 days past the due date.",
        "You can make payment through the Payments section in the app or via online banking to our community account."
    ],
    "action": {
        "label": "Pay Now",
        "url": "/payments"
    },
    "is_read": false,
    "created_at": "2024-10-24T09:58:00Z",
    "time_ago": "2 minutes ago"
}
```

### PUT `/api/notifications/{id}/read`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "Notification marked as read"
}
```

### PUT `/api/notifications/read-all`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "message": "All notifications marked as read"
}
```

---

## 7. Payments

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/payments` | List payment items |
| `GET` | `/api/payments/outstanding` | Total outstanding balance |
| `GET` | `/api/payments/{id}` | Detail payment |
| `POST` | `/api/payments/{id}/pay` | Process payment |
| `GET` | `/api/payments/history` | Payment history |
| `GET` | `/api/user/payment-methods` | Saved payment methods |

### GET `/api/payments`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Security Fee (Sept)",
            "amount": 50.00,
            "currency": "MYR",
            "status": "overdue",
            "due_date": "2024-10-20",
            "due_label": "Due 3 days ago",
            "icon": "solar:bill-list-linear",
            "icon_bg": "bg-red-50",
            "icon_color": "text-red-500"
        },
        {
            "id": 2,
            "title": "Badminton Court",
            "amount": 35.00,
            "currency": "MYR",
            "status": "pending",
            "due_date": "2024-10-30",
            "due_label": "Due Oct 30",
            "icon": "solar:ticket-linear",
            "icon_bg": "bg-amber-50",
            "icon_color": "text-amber-500"
        },
        {
            "id": 3,
            "title": "Security Fee (Aug)",
            "amount": 50.00,
            "currency": "MYR",
            "status": "paid",
            "paid_date": "2024-08-28",
            "due_label": "Paid Aug 28",
            "icon": "solar:verified-check-linear",
            "icon_bg": "bg-green-50",
            "icon_color": "text-green-500"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 3
    }
}
```

### GET `/api/payments/outstanding`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "total": 85.00,
    "currency": "MYR",
    "count": 2
}
```

### GET `/api/payments/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "id": 1,
    "title": "Security Fee (Sept)",
    "amount": 50.00,
    "currency": "MYR",
    "status": "overdue",
    "invoice_id": "#INV-2024-009",
    "due_date": "2024-10-20",
    "billing_to": "Rizky Ahmad",
    "community": {
        "id": 1,
        "name": "Taman Melati Residents"
    }
}
```

### POST `/api/payments/{id}/pay`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "payment_method_id": 1
}
```

**Response (200):**
```json
{
    "message": "Payment successful",
    "transaction_id": "TXN-2024-001",
    "paid_at": "2024-10-24T10:00:00Z"
}
```

### GET `/api/payments/history`

**Headers:** `Authorization: Bearer {token}`

**Query Params:**
- `page` (optional)

**Response (200):**
```json
{
    "data": [
        {
            "id": 3,
            "title": "Security Fee (Aug)",
            "amount": 50.00,
            "currency": "MYR",
            "status": "paid",
            "paid_date": "2024-08-28",
            "transaction_id": "TXN-2024-000"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "total": 1
    }
}
```

### GET `/api/user/payment-methods`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "type": "credit_card",
            "label": "Credit Card",
            "last_four": "4242",
            "is_default": true
        },
        {
            "id": 2,
            "type": "fpx",
            "label": "FPX / Online Banking",
            "is_default": false
        }
    ]
}
```

---

## Error Responses

Semua error menggunakan format yang konsisten:

**401 Unauthorized:**
```json
{
    "message": "Unauthenticated"
}
```

**404 Not Found:**
```json
{
    "message": "Resource not found"
}
```

**422 Validation Error:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

**500 Server Error:**
```json
{
    "message": "Something went wrong"
}
```

---

## Summary

| Module | Endpoints |
|--------|-----------|
| Auth | 4 |
| User / Profile | 3 |
| Communities | 8 |
| Announcements | 2 |
| Activities | 4 |
| Notifications | 4 |
| Payments | 6 |
| **Total** | **31** |
