# REST Routes

## all available slots by a specific rooom
GET http://localhost/api/rooms/1/available-slots
> Where is `1` is a room number

### Params

| param            | value | desc                                          | is_required |
|:-----------------|:------|-----------------------------------------------|:------------|
| `reserved_by_id` | 1     | user id, instead of get the id from the token | Optional    |
| `is_reserved`    | false | get only free slots for the room              | Optional    |


---
## Reserve a new slot
POST http://localhost/api/rooms/1/reserve
> Where is `1` is a room number

### Params
| param            | value | desc                                          | is_required |
|:-----------------|:------|-----------------------------------------------|:------------|
| `timeslot_id`    | 8     | ID time_slot from available-slots request     | Required    |
| `reserved_by_id` | 1     | user id, instead of get the id from the token | Required    |
