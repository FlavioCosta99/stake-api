# Stake API

## Setup

```bash
# Copy environment configuration
cp .env.example .env

# Start Docker containers
docker-compose up -d

# Install dependencies
docker compose exec php composer install

# Generate application key
./php artisan key:generate

# Run migrations and seed the database
./php artisan migrate:fresh --seed
```

## API Endpoints

### List Property Campaigns

```
GET http://localhost:8080/api/v1/properties/:property_id/campaigns
```

#### Available Filters

| Parameter          | Type   | Description             |
| ------------------ | ------ | ----------------------- |
| name               | string | Filter by campaign name |
| target_amount_from | float  | Minimum target amount   |
| target_amount_to   | float  | Maximum target amount   |

#### Example Response

```json
{
    "data": [
        {
            "id": 4,
            "name": "4 bedroom property in Asa Mountain",
            "image_url": null,
            "percentage_raised": "0%",
            "target_amount": 265491180000,
            "number_of_investors": 0,
            "investment_multiple": 360,
            "property": {
                "id": 14,
                "city": "Americoland",
                "area": "Asa Mountain"
            }
        }
    ],
    "links": {
        "first": "http://localhost:8080/api/v1/properties/14/campaigns?page=1",
        "last": "http://localhost:8080/api/v1/properties/14/campaigns?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8080/api/v1/properties/14/campaigns?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://localhost:8080/api/v1/properties/14/campaigns",
        "per_page": 50,
        "to": 1,
        "total": 1
    }
}
```

### Invest in a Campaign

```
POST http://localhost:8080/api/v1/properties/:property_id/campaigns/:campaign_id/invest?amount=822.00
```

#### Example Response

```json
{
    "data": {
        "id": 2051,
        "campaign": {
            "id": 4,
            "name": "4 bedroom property in Asa Mountain",
            "image_url": null,
            "percentage_raised": "0.0000000014%",
            "target_amount": 265491180000,
            "number_of_investors": 1,
            "investment_multiple": 360,
            "property": {
                "id": 14,
                "city": "Americoland",
                "area": "Asa Mountain"
            }
        },
        "amount": 360,
        "percentage": "0.0000000014%",
        "created_at": "2025-03-24T10:01:10.000000Z",
        "updated_at": "2025-03-24T10:01:10.000000Z"
    }
}
```

## Commands

### Distribute Dividends

Distribute dividends to all investors of a property:

```bash
./php artisan investments:distribute-dividend {property_id} {amount}
```
