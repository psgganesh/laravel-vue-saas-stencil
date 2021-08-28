<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cerbero\CommandValidator\ValidatesInput;

class CreateSubscriptionPlan extends Command
{
    use ValidatesInput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:plan:create  
                            {name : The name of the plan} 
                            {description : One line description of the plan}
                            {every : How long should be the invoice period?}
                            {frequency : How frequently should be the invoice interval?}
                            {currency : Which currency does this subscription plan belong to?}
                            {order : Priority / sort order of this subscription plan}
                            {--with-trial}
                            {period? : How long should be the trial period?}
                            {interval? : How frequently should be the trial interval?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new subscription / pricing plan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Validation rules for the input.
     *
     * @param  string $question
     * @param  string $default
     * @param  callable|null $validator
     * @return string
     */
    protected function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'every' => 'required_if:with-trial,true|numeric|min:1|max:365',
            'frequency' => 'required_if:with-trial,true|alpha|in:day,month,year',
            'period' => 'required_if:with-trial,true|numeric|min:1|max:365',
            'interval' => 'required_if:with-trial,true|alpha|in:day,month,year',
            'order' => 'required|numeric|min:1',
            'currency' => 'required|alpha'
        ];
    }

    /**
     * Retrieve the custom error messages
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'min' => 'The minimum allowed :attribute is :min'
        ];
    }

    /**
     * Retrieve the custom attribute names for error messages
     *
     * @return array
     */
    protected function attributes()
    {
        return [
            'every' => 'invoice interval',
            'frequency' => 'invoice interval',
            'period' => 'trial period',
            'interval' => 'trial interval',
            'order' => 'sort order'
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $planName = $this->argument('name');
        $planDescription = $this->argument('description');
        $invoiceEvery = $this->argument('every');
        $invoiceFrequency = $this->argument('frequency');
        $trialPeriod = $this->argument('period');
        $trialInterval = $this->argument('interval');
        $currency = $this->argument('currency');
        $order = $this->argument('order');

        // $payload = [
        //     'name' => $name,
        //     'description' => $description,
        //     'price' => 9.99,
        //     'signup_fee' => 1.99,
        //     'invoice_period' => 1,
        //     'invoice_interval' => 'month',
        //     'trial_period' => 15,
        //     'trial_interval' => 'day',
        //     'sort_order' => 1,
        //     'currency' => 'USD',
        // ];
        // $plan = app('rinvex.subscriptions.plan')->create($payload);

    }
}
