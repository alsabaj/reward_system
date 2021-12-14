## Reward System

Simple reward system in Laravel Framework 8.65.

## Installation

Go to the project folder in command prompt.

Run composer install.

```bash
composer install
```

Create a new database in MySQL database named 'reward_system'.

Migrate:
```bash
php artisan migrate
```

Seed:
```bash
php artisan db:seed
```

Run:

```bash
php artisan serve
```

### Features

- Customers will be rewarded with Points when Sales Order is in “Complete” status.
- Every USD $1 sales amount will be rewarded with 1 point, if the sales amount is not USD, convert to the equivalent amount in USD for reward   amount calculation.
- The reward amount will be credited into the customer account with the expiry date, which is 1 year later.
- Points can be used for new order payment, every 1 point equivalent to USD $0.01.

### Currency
Currencies table have name, code and exchange rate parameters. USD is used as the default currency.

### Customers
Customers information, current reward points and their reward history can be viewed from customers page.

### Orders

Orders page displays the list of existing orders. New orders can be added by selecting customer, currency and sales amount.

<ul>
    <li>
        Orders will have two status, "Pending" and "Completed". New orders will be marked as "Pending".
    </li>
    <li>
        User can Mark the order as "Completed" for the pending orders by pressing "Mark as completed" button.
    </li>
</ul>

### Rewards
Each customer reward has 'reward_points', 'is_expired' and 'expiry_date'. 

'reward_points' represents the amount of points earned from a completed order. 

'is_expired' represents whether the reward has expired or not.

'expiry_date' represents the expiry date of the reward.

### Rewards Earned Calculation
Rewards are calculated once the "Mark as Completed" button is pressed. The completion of order and awarding of reward points is done in following steps:

<ul>
    <li>
        Reward points is calculated from sales amount using currency conversion factor. 
    </li>
    <li>
        Reward expiry date is evaluated by adding a year to current date. 
    </li>
    <li>
        New reward record is entered in rewards table.
    </li>
    <li>
       The reward amount is credited into the customer.
    </li>
    <li>
        Status of order is marked as "Completed"
    </li>
</ul>

### Rewards Expiry Check using daily Cron Job

Artisan Command to expire reward points based on their expiry date
```bash
php artisan reward:expire
```

The expiry check of the rewards points is performed by running cron job once in a day. The action to be executed in cron job consists of following steps:

<ul>
    <li>
        Get all customers from users table.
    </li>
    <li>
       For each customers repeat following the steps:
    </li>
    <ul>
        <li>
            Calculate the sum of customer's unexpired reward points that have expiry_date greater than current date.
        </li>
        <li>
            If the customer's reward points is greater than their unexpired points, then replace their reward points with their unexpired points.
        </li>
        <li>
            Update customers reward points in the database.
        </li>
        <li>
            Set 'is_expired' value to 'true' for the unexpired reward records that have expiry date less than or equal to current date.
        </li>
    </ul>
</ul>


## Screenshots


#### Customers Page:
![Customers Image 1](https://github.com/alsabaj/reward_system/blob/main/userlist.png)

#### Orders Page:
![Orders Image 2](https://github.com/alsabaj/reward_system/blob/main/orders.png)

#### Create Order Page:
![Create Order Image 2](https://github.com/alsabaj/reward_system/blob/main/create_order.png)

#### Rewards Page:
![Rewards Image 2](https://github.com/alsabaj/reward_system/blob/main/rewards.png)