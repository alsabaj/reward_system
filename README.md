## Reward System

Simple reward system in Laravel Framework 8.65.

## Installation

Go to the project folder in command prompt.

Run composer install.

```bash
composer install
```

Create a new database in MySQL database named 'reward_system'.

Now import the SQL file named 'reward_system.sql' which is located in the root folder.

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

### Users/Customers
Customers information, current available reward points and their reward history can be viewed from customers page.

### Orders

Orders page displays the list of existing orders. New orders can be added by selecting customer, currency and sales amount. There is also a feature to redeem rewards points while adding a new order. 

<ul>
    <li>
        Orders will have two status, "Pending" and "Completed". New orders will be marked as "Pending".
    </li>
    <li>
        User can Mark the order as "Completed" for the pending orders by pressing "Mark as completed" button.
    </li>
</ul>

### Rewards
Each customer reward has 'total_points', 'available_points' and 'expiry_date'. 

'total_points' represents the amount of points earned from a completed order. 

'available_points' represents the remaining points which can be redeemed/used when placing an order. Initially, 'total_points' and 'available_points' are of same value. But 'available_points' will decrease depending on how many points the customer spends. Hence, some reward points may get partially utilized; while some may get fully utilized before their expiry.

'expiry_date' represents the expiry date/time of the reward.

### Available Points Calculation
Available Reward Points of a customer is calculated as the sum of available_points from each rewards records, which have expiry_date greater than current date.

### Rewards Earned Calculation
Rewards are calculated once the "Mark as Completed" button is pressed. The completion of order and awarding of reward points is done in following steps:

<ul>
    <li>
        Reward points is calculated from sales amount using currency conversion factor obtained from currencies table. 
    </li>
    <li>
        Reward expiry date is evaluated by adding a year to current date. 
    </li>
    <li>
        New reward record is entered in rewards table.
    </li>
    <li>
        Status of order is marked as "Completed"
    </li>
</ul>

### Rewards Spent Calculation

When the customer chooses to use of their reward point to place an order, the following steps are performed:

<ul>
    <li>
        Calculate points equivalent to order's sales amount. 
    </li>
    <li>
        Get the current available points in customer's account. If the customer doesn't have enough points, then the transaction is terminated with an error message.
    </li>
    <li>
       Get the customer's all available and unexpired rewards, which have points available for redemption. The rewards are fetched in ascending order of expiry date, so that the older rewards get utilized first.
    </li>
    <li>
        Loop through each rewards and deduct from available_points of each reward until all the points required for the transaction have been redeemed.
    </li>
    <li>
        Create new order for the customer.
    </li>
</ul>

## Screenshots


#### Customers Page:
![Customers Image 1](https://github.com/alsabaj/reward_system/blob/main/users.png)

#### Orders Page:
![Orders Image 2](https://github.com/alsabaj/reward_system/blob/main/orders.png)

#### Create Order Page:
![Create Order Image 2](https://github.com/alsabaj/reward_system/blob/main/create_order.png)

#### Rewards Page:
![Rewards Image 2](https://github.com/alsabaj/reward_system/blob/main/rewards.png)