//
//  WaitingRoomViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "VerificationViewController.h"
#import "TheNavigationController.h"
#import "GameState.h"

@interface VerificationViewController (){
    NSMutableData *responseData;
    BOOL isRequesting;
}

@end

@implementation VerificationViewController


- (void)viewDidLoad
{
    [super viewDidLoad];
    [self sendEmail];
    
    self.title = @"Verification";
    self.navigationController.navigationItem.leftBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"Logout" style:UIBarButtonItemStylePlain target:nil action:nil];
    
    [self prepTheBackground];
	// Do any additional setup after loading the view.
}
- (void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    [[self navigationController] setNavigationBarHidden:NO animated:YES];
    
}

- (void)prepTheBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"debut_light.png"]];
    self.view.backgroundColor = backgroundColor;
}

- (void)sendEmail{
    NSString *unverifiedID = [[GameState sharedGameState] getUserID];

    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/sendemail.php?userid=%@", unverifiedID];
    NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    NSError *error;
    [NSURLConnection sendSynchronousRequest:request returningResponse:nil error:&error];
    
    if(error){
        [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not send email - no internet access" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }else{

    }

}

- (IBAction)checkVerified:(id)sender {
    if(isRequesting) return;
    
    isRequesting = YES;
    
    NSString *userid = [[GameState sharedGameState] getUserID];
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/verified.php?userid=%@", userid];
    
    NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}

- (IBAction)sendAnotherEmail:(id)sender {
    [self sendEmail];
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
    isRequesting = YES;
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    isRequesting = NO;
    NSString *response = [[NSString alloc] initWithData:responseData encoding: NSASCIIStringEncoding];
    
    if([response isEqualToString:@"verified"]){
        [(TheNavigationController *)[self navigationController] nextAfterVerification];
    }else if([response isEqualToString:@"unverified"]){
        [[[UIAlertView alloc] initWithTitle:@"Not Verified" message:@"You have not verified your account yet" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }else if([response isEqualToString:@"late"]){
         [[[UIAlertView alloc] initWithTitle:@"Too Late" message:@"Sorry, you're too late. Selection has started already." delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];   
    }
}
@end
