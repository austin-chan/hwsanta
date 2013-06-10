//
//  SantaModel.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/26/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SantaModel.h"
#import "GameState.h"
#import "LoginViewController.h"

@interface SantaModel (){
    NSMutableData *responseData;
    LoginViewController *log;
}

@end

@implementation SantaModel

+ (SantaModel *)sharedSantaModel{
    static SantaModel *sharedSantaModel = nil;
    if(!sharedSantaModel){
        sharedSantaModel = [[super allocWithZone:nil] init];
    }
    return sharedSantaModel;
}



- (NSString *)checkMyRecipient:(NSString *)userId{
    NSURL *url = [NSURL URLWithString:[[NSString stringWithFormat:@"http://hwsanta.com/app/home/checkmyrecipient.php?userid=%@", userId] stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    NSURLRequest *req = [NSURLRequest requestWithURL:url];
    
    NSURLResponse *response = nil;
    NSError *error = nil;
    NSData *data = [NSURLConnection sendSynchronousRequest:req returningResponse:&response error:&error];
    if(data != nil){
        return [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
    }
    return nil;
}

- (NSString *)checkMySanta:(NSString *)userId{
    NSURL *url = [NSURL URLWithString:[[NSString stringWithFormat:@"http://hwsanta.com/app/home/checkmysanta.php?userid=%@", userId] stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    NSURLRequest *req = [NSURLRequest requestWithURL:url];
    
    NSURLResponse *response = nil;
    NSError *error = nil;
    NSData *data = [NSURLConnection sendSynchronousRequest:req returningResponse:&response error:&error];
    if(data != nil){
        return [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
    }
    return nil;
}

- (NSString *)checkMyName:(NSString *)userId{
    NSURL *url = [NSURL URLWithString:[[NSString stringWithFormat:@"http://hwsanta.com/app/home/checkme.php?userid=%@", userId] stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];    NSURLRequest *req = [NSURLRequest requestWithURL:url];
    
    NSURLResponse *response = nil;
    NSError *error = nil;
    NSData *data = [NSURLConnection sendSynchronousRequest:req returningResponse:&response error:&error];
    if(data != nil){
        return [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
    }
    return nil;
}

- (int)daysUntilSantageddon{

    NSString *date = [NSString stringWithFormat:@"201212210000"];
    NSDateFormatter *dateFormatter =[[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"yyyyMMddHHmm"];
    
    NSDate *santageddon = [dateFormatter dateFromString:date];

    
    int timeInterval = [santageddon timeIntervalSinceNow];
    timeInterval /= 60; //seconds -> minutes
    timeInterval /= 60; //minutes -> hours
    timeInterval /= 24; //hours -> days
    timeInterval++; //but add one cuz of truncation yup
    
    return timeInterval;
}

+ (NSString *)getU{
    return [[GameState sharedGameState] getUserID];
}

- (void)loginRequestWithUsername:(NSString *)username andPassword:(NSString *)password forLoginView:(LoginViewController *)loginView{

    log = loginView;
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/login.php?username=%@&password=%@", username, password];
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}































- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server. Try again" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    
    NSError *error;
    NSDictionary *response = [NSJSONSerialization JSONObjectWithData:responseData options:kNilOptions error:&error];
    
    if([response objectForKey:@"exists"] != nil){
        [[[UIAlertView alloc] initWithTitle:@"Incorrect Login" message:@"We could not log you in with that combination." delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
        [log notReadyToLogin];
        return;
    }
    
    [[GameState sharedGameState] setUserID:[response objectForKey:@"userid"]];
    [[GameState sharedGameState] saveStage:[response objectForKey:@"stage"]];
    
    [log readyToLogin];
    
}

@end
