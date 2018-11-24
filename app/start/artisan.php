<?php

/*
  |--------------------------------------------------------------------------
  | Register The Artisan Commands
  |--------------------------------------------------------------------------
  |
  | Each available Artisan command must be registered with the console so
  | that it is available to be called. We'll register every command so
  | the console gets access to each of the command object instances.
  |
 */
Artisan::add(new ScheduleDispatcherCommand);
Artisan::add(new GenerateSelectorCommand);
//Artisan::add(new CalculatePrizeCommand);
Artisan::add(new TestQueuePushCommand);
Artisan::add(new BeanstalkdStatusCommand);
Artisan::add(new ClearBeanstalkdQueueCommand);
Artisan::add(new GetCodeFromEC2);
Artisan::add(new CalculateFloat);
Artisan::add(new CalculateDividend);
Artisan::add(new CalculateDailySalary);
Artisan::add(new UpdatePrizeSet);
Artisan::add(new AddUserPrizeSetForNewLottery);
Artisan::add(new AddPrizeDetailForSeries);
Artisan::add(new ActivityPlayerEveryDayGetMoney);

Artisan::add(new ActivityDailyDepositBack);
Artisan::add(new ActivityAgentDailyTurnoverRebate);
Artisan::add(new ActivityAgentDailyTurnoverRebateUpgrade);
Artisan::add(new ActivityAgentDailyDepositRebate);
Artisan::add(new CreateActivityReportUserPrize);
Artisan::add(new ReportDownload);
Artisan::add(new AccountReportDownload);
//Artisan::add(new CreateActivityReportData);

Artisan::add(new ReleaseAllDeadAccountLock);

// 开奖
Artisan::add(new GenerateNumber);
// 测试
Artisan::add(new TestWnNumber);
Artisan::add(new TestRedis);
Artisan::add(new TestK3Number);

// Stat
Artisan::add( new UpdateProfitCommand);
Artisan::add( new UpdateUserProfitCommand);
Artisan::add( new UpdateTeamProfitCommand);
Artisan::add( new UpdateMonthProfitCommand);
Artisan::add( new UpdateUserMonthProfitCommand);
// prize group
Artisan::add( new UpdatePrizeGroupCommand);
// issue
Artisan::add( new GenerageIssue);

// Way Groups
Artisan::add( new GenerateWayGroupData);
// db
Artisan::add( new checkAndMakePartition);
// Register Link Update
Artisan::add( new UpdateRegisterLinkPrizeGroupCommand);

// Payments
Artisan::add( new ResetPaymentAccounts);

